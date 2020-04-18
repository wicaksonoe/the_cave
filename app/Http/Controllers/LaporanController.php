<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Detail_penjualan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function dashboard($bulan, $tahun, $param)
    {
        switch ($param) {
            case 'all':
                # code...
                break;

            case 'bazar':
                # code...
                break;

            case 'global':
                return $this->dashboard_global($bulan, $tahun);
                break;

            default:
                # code...
                break;
        }
    }

    public function dashboard_global($bulan, $tahun)
    {
        # get 10 barang terlaris di penjualan global, dalam bulan dan tahun tertentu

        $daftar_barcode = Detail_penjualan::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->selectRaw('barcode, sum(jumlah) as jumlah')
            ->groupBy('barcode')
            ->orderBy('jumlah', 'desc')
            ->limit(10)
            ->get();

        $daftar_barang_laris = [];

        foreach ($daftar_barcode as $key => $value) {
            array_push($daftar_barang_laris, [
                'barcode' => $value->barcode,
                'nama_barang' => Barang_masuk::where('barcode', $value->barcode)->withTrashed()->first()->namabrg,
                'jumlah' => $value->jumlah
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => $daftar_barang_laris,
        ], 200
    );

    }
}
