<?php

namespace App\Http\Controllers;

use App\DetailPenjualan;
use App\Http\Requests\PenjualanRequest;
use App\Penjualan;
use DateTime;
use DateTimeZone;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function get($kode_trx = null)
    {
        if ($kode_trx == null) {
            $daftar_transaksi = Penjualan::all('kode_trx', 'username', 'created_at');
            return DataTables::of($daftar_transaksi)
                ->addColumn('aksi', function ($i) {
                    return '<button class="btn btn-sm btn-info" value="' . $i->kode_trx . '" onclick="funct(this.value)">Lihat Transaksi</button>';
                })
                ->addColumn('nama_pegawai', function ($i) {
                    return $i->include_user->nama;
                })
                ->addColumn('tanggal_transaksi', function ($i) {
                    $tanggal = new DateTime($i->created_at);
                    $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

                    return $tanggal->format("d-M-Y H:i T");
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $data_barang = [];
            $penjualan = Penjualan::findOrFail($kode_trx);

            $barangs = $penjualan->include_detail_penjualan()->get(['barcode', 'jumlah']);
            foreach ($barangs as $key => $barang) {

                $harga = null;
                if ($barang->jumlah <= 12) {
                    $harga = $barang->include_barang_masuk->hpp ?? null;
                } else if ($barang->jumlah <= 20) {
                    $harga = $barang->include_barang_masuk->hpp ?? null;
                }

                $data_barang[$key] = [
                    'barcode'     => $barang->barcode,
                    'nama_barang' => $barang->include_barang_masuk->namabrg ?? null,
                    'jumlah'      => $barang->jumlah,
                    'harga_jual'  => $harga,
                ];
            }

            $tanggal = new DateTime($penjualan->created_at);
            $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

            $data_transaksi = [
                'kode_trx'          => $penjualan->kode_trx,
                'nama_pegawai'      => $penjualan->include_user->nama,
                'tanggal_penjualan' => $tanggal->format("j M Y G:i T"),
                'barang'            => $data_barang,
            ];

            return response()->json([
                'success' => true,
                'data'    => $data_transaksi
            ]);
        }
    }

    public function create(PenjualanRequest $request)
    {
        $username = $this->user->username;

        $prefix = "TRX-STR-";
        $latest_key = Penjualan::latest('created_at')->first()->kode_trx ?? null;    // kalau ternyata tabel masih kosong, $latest_key bernilai null / 0
        $latest_key = str_replace($prefix, '', (string) $latest_key);   // menghapus $prefix untuk mendapat angkanya saja

        $new_key = (int) $latest_key + 1;

        $kode_trx = $prefix . str_pad((string) $new_key, 6, "0", STR_PAD_LEFT);

        // Buat record penjualan baru
        try {
            Penjualan::create([
                'kode_trx' => $kode_trx,
                'username' => $username,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        // Persiapan data untuk BULK Insert ke tabel DetailPenjualan
        $data = [];
        foreach ($request->barcode as $key => $value) {
            $new_data = [
                'kode_trx'   => $kode_trx,
                'barcode'    => $value,
                'jumlah'     => $request->jumlah[$key] ?? null,
                'created_at' => DB::raw('now()'),
                'updated_at' => DB::raw('now()'),
            ];

            array_push($data, $new_data);
        }

        // Coba memasukan entry
        try {
            DetailPenjualan::insert($data);
        } catch (QueryException $e) {
            // Kalau ada error, record di tabel Penjualan sebelumnya akan dihapus bersih
            $penjualan_existing = Penjualan::findOrFail($kode_trx);
            $penjualan_existing->forceDelete();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi sukses.'
        ]);
    }
}
