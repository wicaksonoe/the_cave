<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Detail_penjualan;
use App\Detail_penjualan_bazar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function dashboard($bulan, $tahun, $param)
    {
        switch ($param) {
            case 'all':
                return $this->dashboard_all($bulan, $tahun);
                break;

            case 'bazar':
                return $this->dashboard_bazar($bulan, $tahun);
                break;

            case 'global':
                return $this->dashboard_global($bulan, $tahun);
                break;

            default:
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Request not found.'
                    ],
                    404
                );
                break;
        }
    }

    public function dashboard_all($bulan, $tahun)
    {
        $daftar_barcode_bazar = Detail_penjualan_bazar::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->selectRaw('barcode, sum(jumlah) as jumlah')
            ->groupBy('barcode')
            ->orderBy('jumlah', 'desc')
            ->get();

        $daftar_barcode_global = Detail_penjualan::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->selectRaw('barcode, sum(jumlah) as jumlah')
            ->groupBy('barcode')
            ->orderBy('jumlah', 'desc')
            ->get();

        $daftar_barcode_gabungan = $daftar_barcode_bazar->mergeRecursive($daftar_barcode_global);

        $daftar_barcode_laris = $daftar_barcode_gabungan->sortByDesc('jumlah');

        $daftar_barang_laris = [];
        foreach ($daftar_barcode_laris as $value) {
            array_push($daftar_barang_laris, [
                'barcode' => $value->barcode,
                'nama_barang' => Barang_masuk::where('barcode', $value->barcode)->withTrashed()->first()->namabrg,
                'jumlah' => $value->jumlah
            ]);

            if (count($daftar_barang_laris) == 10) {
                break;
            }
        }

        return response()->json(
            [
                'success' => true,
                'jumlah_data' => count($daftar_barang_laris),
                'data' => $daftar_barang_laris
            ],
            200
        );
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

        return response()->json(
            [
                'success' => true,
                'jumlah_data' => count($daftar_barang_laris),
                'data'    => $daftar_barang_laris,
            ],
            200
        );
    }

    public function dashboard_bazar($bulan, $tahun)
    {
        $daftar_barcode = Detail_penjualan_bazar::whereMonth('created_at', $bulan)
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

        return response()->json(
            [
                'success' => true,
                'jumlah_data' => count($daftar_barang_laris),
                'data'    => $daftar_barang_laris,
            ],
            200
        );
    }
}
