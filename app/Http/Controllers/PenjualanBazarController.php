<?php

namespace App\Http\Controllers;

use App\Bazar;
use App\Http\Requests\Bazar\CreatePenjualanRequest;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PenjualanBazarController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function get($id_bazar, $kode_trx = null)
    {
        $data_bazar = Bazar::findOrFail($id_bazar);

        if ($kode_trx == null) {
            $daftar_transaksi = $data_bazar
                ->include_penjualan_bazar()
                ->get(['kode_trx', 'username', 'created_at']);

            return DataTables::of($daftar_transaksi)
                ->addColumn('nama_pegawai', function ($trx) {
                    return $trx->include_user->nama;
                })
                ->addColumn('tanggal_transaksi', function ($trx) {
                    $tanggal = new DateTime($trx->created_at);
                    $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

                    return $tanggal->format("d-M-Y H:i T");
                })
                ->make(true);
        } else {
            $penjualan = $data_bazar
                ->include_penjualan_bazar()
                ->where('kode_trx', $kode_trx)
                ->firstOrFail();

            $daftar_barang = $penjualan
                ->include_detail_penjualan_bazar()
                ->get();

            $barang = [];

            foreach ($daftar_barang as $key => $val) {
                $harga_barang = $val->include_barang_masuk->hjual;
                $potongan = $data_bazar->potongan;
                $hjual = $harga_barang - $potongan;

                array_push($barang, [
                    'barcode'     => $val->barcode,
                    'nama_barang' => $val->include_barang_masuk->namabrg,
                    'jumlah'      => $val->jumlah,
                    'hjual'       => $hjual,
                ]);
            }

            $tanggal = new DateTime($penjualan->created_at);
            $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

            $data_transaksi = [
                'kode_trx'          => $penjualan->kode_trx,
                'nama_pegawai'      => $penjualan->include_user->nama,
                'tanggal_penjualan' => $tanggal->format("j M Y G:i T"),
                'barang'            => $barang,
            ];

            return response()->json([
                'success' => true,
                'data'    => $data_transaksi
            ]);
        }
    }

    public function create($id_bazar, CreatePenjualanRequest $request)
    {
        // return print_r($request->all());
        $data_bazar = Bazar::findOrFail($id_bazar);

        $username = $this->user->username;

        $prefix_bazar = str_pad($data_bazar->id, 3, '0', STR_PAD_LEFT);
        $prefix = "TRX-BZR-" . $prefix_bazar . '-';

        $latest_key = $data_bazar->include_penjualan_bazar()->latest('created_at')->first()->kode_trx ?? null;    // kalau ternyata tabel masih kosong, $latest_key bernilai null / 0
        $latest_key = str_replace($prefix, '', (string) $latest_key);   // menghapus $prefix untuk mendapat angkanya saja

        $new_key = (int) $latest_key + 1;

        $kode_trx = $prefix . str_pad((string) $new_key, 6, "0", STR_PAD_LEFT);

        $detail_penjualan = [];
        foreach ($request->barcode as $key => $value) {
            // Validasi stock
            $stock = StockController::validate_stock_for_bazar($id_bazar, $request->barcode[$key], $request->jumlah[$key]);

            if ($stock == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock barang dengan barcode ' . $request->barcode[$key] . ' kurang dari permintaan. Mohon cek kembali stock di gudang terlebih dahulu.',
                ], 422);
            }

            array_push($detail_penjualan, [
                'barcode' => $request->barcode[$key],
                'jumlah'  => $request->jumlah[$key] ?? null,
            ]);
        }

        // Buat record penjualan baru
        try {
            $penjualan = $data_bazar
                ->include_penjualan_bazar()
                ->create([
                    'kode_trx' => $kode_trx,
                    'username' => $username,
                ])->include_detail_penjualan_bazar()
                ->createMany($detail_penjualan);
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
}
