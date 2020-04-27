<?php

namespace App\Http\Controllers;

use App\Penjualan;
use DateTime;
use DateTimeZone;
use Illuminate\Database\QueryException;
use App\Http\Requests\Penjualan\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
        $this->middleware('isRoleAdmin', ['except' => ['get', 'laporan_trx']]);
    }

    public function get($kode_trx = null)
    {
        if ($kode_trx == null) {
            $daftar_transaksi = Penjualan::all('kode_trx', 'username', 'created_at');
            return DataTables::of($daftar_transaksi)
                ->addColumn('aksi', function ($i) {
                    return '<a href="' . route('penjualan.detil_penjualan', $i->kode_trx) . '" class="btn btn-sm btn-info">Lihat Transaksi</a>';
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
            $data_barang = [
                'retur' => [],
                'real'  => [],
            ];

            $penjualan = Penjualan::findOrFail($kode_trx);

            $barangs = $penjualan
                ->include_detail_penjualan()
                ->withTrashed()
                ->get([
                    'barcode',
                    'jumlah',
                    'harga_partai',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]);

            foreach ($barangs as $key => $barang) {

                $status_retur = isset($barang->deleted_at);

                if ($status_retur == true) {
                    array_push($data_barang['retur'], [
                        'barcode'      => $barang->barcode,
                        'nama_barang'  => $barang->include_barang_masuk()->withTrashed()->first()->namabrg ?? null,
                        'jumlah'       => $barang->jumlah,
                        'harga_partai' => $barang->harga_partai,
                        'hjual'        => $barang->include_barang_masuk()->withTrashed()->first()->hjual ?? null,
                        'grosir'       => $barang->include_barang_masuk()->withTrashed()->first()->grosir ?? null,
                        'partai'       => $barang->include_barang_masuk()->withTrashed()->first()->partai ?? null,
                    ]);
                } else {
                    array_push($data_barang['real'], [
                        'barcode'      => $barang->barcode,
                        'nama_barang'  => $barang->include_barang_masuk()->withTrashed()->first()->namabrg ?? null,
                        'jumlah'       => $barang->jumlah,
                        'harga_partai' => $barang->harga_partai,
                        'hjual'        => $barang->include_barang_masuk()->withTrashed()->first()->hjual ?? null,
                        'grosir'       => $barang->include_barang_masuk()->withTrashed()->first()->grosir ?? null,
                        'partai'       => $barang->include_barang_masuk()->withTrashed()->first()->partai ?? null,
                    ]);
                }
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

    public function create(CreateRequest $request)
    {
        $username = $this->user->username;

        $prefix = "TRX-STR-";
        $latest_key = Penjualan::latest('created_at')->first()->kode_trx ?? null;    // kalau ternyata tabel masih kosong, $latest_key bernilai null / 0
        $latest_key = str_replace($prefix, '', (string) $latest_key);   // menghapus $prefix untuk mendapat angkanya saja

        $new_key = (int) $latest_key + 1;

        $kode_trx = $prefix . str_pad((string) $new_key, 6, "0", STR_PAD_LEFT);

        $detail_penjualan = [];
        foreach ($request->barcode as $key => $value) {
            // Validasi stock
            $stock = StockController::validate_stock($request->barcode[$key], $request->jumlah[$key]);

            if ($stock == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock barang dengan barcode ' . $request->barcode[$key] . ' kurang dari permintaan. Mohon cek kembali stock di gudang terlebih dahulu.',
                ], 422);
            }

            array_push($detail_penjualan, [
                'barcode' => $request->barcode[$key],
                'jumlah'  => $request->jumlah[$key] ?? null,
                'harga_partai' => $request->harga_partai[$key],
            ]);
        }

        // Buat record penjualan baru
        try {
            $penjualan = Penjualan::create([
                'kode_trx' => $kode_trx,
                'username' => $username,
            ]);

            $penjualan->include_detail_penjualan()->createMany($detail_penjualan);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi sukses.'
        ], 200);
    }

    public function retur_barang($kode_trx, Request $request)
    {
        // Validasi input
        $rules = [
            'barcode'           => 'bail|required|min:15|max:15',
            'barcode_pengganti' => 'bail|required|min:15|max:15',
            'jumlah'            => 'bail|required|min:1',
        ];

        $messages = [
            'barcode.required' => 'Kolom barcode tidak boleh kosong.',
            'barcode.min'      => 'Kolom barcode harus 15 digit',
            'barcode.max'      => 'Kolom barcode harus 15 digit',

            'barcode_pengganti.required' => 'Kolom barcode pengganti tidak boleh kosong.',
            'barcode_pengganti.min'      => 'Kolom barcode pengganti harus 15 digit',
            'barcode_pengganti.max'      => 'Kolom barcode pengganti harus 15 digit',

            'jumlah.required' => 'Kolom jumlah barang tidak boleh kosong.',
            'jumlah.min'      => 'Minimal jumlah penjualan 1',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();


        // Validasi stock
        $stock = StockController::validate_stock($request->barcode_pengganti, $request->jumlah);
        if (!$stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stock barang dengan barcode ' . $request->barcode_pengganti . ' kurang dari permintaan. Mohon cek kembali stock di gudang terlebih dahulu.',
            ], 422);
        }


        // proses retur barang
        $penjualan = Penjualan::findOrFail($kode_trx);

        $existing = $penjualan
            ->include_detail_penjualan()
            ->where('barcode', $request->barcode);

        $jumlah_pembelian = $existing->first()->jumlah;
        $sisa_barang_retur = (int) $jumlah_pembelian - (int) $request->jumlah;

        if ($sisa_barang_retur == 0) {
            // buat data penyesuaian, lalu hapus data sebelumnya
            $barang_pengganti = $penjualan
                ->include_detail_penjualan()
                ->create([
                    'barcode' => $request->barcode_pengganti,
                    'jumlah' => $request->jumlah,
                ]);
            $existing->delete();
        } else {
            // buat data penyesuaian dan sisa penyesuaian, lalu hapus data sebelumnya
            $barang_pengganti = $penjualan
                ->include_detail_penjualan()
                ->createMany([
                    [
                        'barcode' => $request->barcode,
                        'jumlah' => $sisa_barang_retur,
                    ],
                    [
                        'barcode' => $request->barcode_pengganti,
                        'jumlah' => $request->jumlah,
                    ]
                ]);

            $existing->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Penyesuaian berhasil.'
        ], 200);
    }

    public function laporan_trx($kode_trx)
    {

    }
}
