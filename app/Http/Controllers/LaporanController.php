<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Biaya;
use App\Bazar;
use App\Detail_penjualan;
use App\Detail_penjualan_bazar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function terlaris($bulan, $tahun, $param)
    {
        switch ($param) {
            case 'all':
                return $this->terlaris_all($bulan, $tahun);
                break;

            case 'bazar':
                return $this->terlaris_bazar($bulan, $tahun);
                break;

            case 'global':
                return $this->terlaris_global($bulan, $tahun);
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

    public function terlaris_all($bulan, $tahun)
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

    public function terlaris_global($bulan, $tahun)
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

    public function terlaris_bazar($bulan, $tahun)
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

    public function penjualan($bulan, $tahun)
    {
        $daftar_biaya_toko = Biaya::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->where('id_bazar', null)
            ->get(['keterangan', 'nominal']);

        $daftar_id_bazar = Biaya::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->where('id_bazar', '!=', null)
            ->groupBy('id_bazar')
            ->get('id_bazar');

        $daftar_biaya_bazar = [];
        foreach ($daftar_id_bazar as $value) {
            $daftar_biaya_bazar[] = [
                'id_bazar' => $value->id_bazar,
                'nama_bazar' => Bazar::where('id', $value->id_bazar)->withTrashed()->first()->nama_bazar,
                'biaya' => Biaya::whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun)
                    ->where('id_bazar', $value->id_bazar)
                    ->get(['keterangan', 'nominal'])
            ];
        }

        $daftar_penjualan_toko = DB::table('detail_penjualans')
            ->whereMonth('detail_penjualans.created_at', $bulan)
            ->whereYear('detail_penjualans.created_at', $tahun)
            ->where('detail_penjualans.deleted_at', null)
            ->join('barang_masuks', 'detail_penjualans.barcode', '=', 'barang_masuks.barcode')
            ->get([
                'detail_penjualans.barcode',
                'barang_masuks.hpp',
                'barang_masuks.hjual',
                'barang_masuks.grosir',
                'barang_masuks.partai',
                'detail_penjualans.harga_partai',
                'detail_penjualans.jumlah',
            ]);

        $total_penjualan_toko = 0;
        foreach ($daftar_penjualan_toko as $value) {
            if ($value->jumlah > 12) {
                if ($value->harga_partai == 1) {
                    $total_penjualan_toko += ($value->jumlah * $value->partai);
                } else {
                    $total_penjualan_toko += ($value->jumlah * $value->grosir);
                }
            } else {
                $total_penjualan_toko += ($value->jumlah * $value->hjual);
            }
        }

        $daftar_penjualan_bazar = DB::table('detail_penjualan_bazars')
            ->whereMonth('detail_penjualan_bazars.created_at', $bulan)
            ->whereYear('detail_penjualan_bazars.created_at', $tahun)
            ->where('detail_penjualan_bazars.deleted_at', null)
            ->join('penjualan_bazars', 'detail_penjualan_bazars.kode_trx', '=', 'penjualan_bazars.kode_trx')
            ->join('bazars', 'penjualan_bazars.id_bazar', '=', 'bazars.id')
            ->join('barang_masuks', 'detail_penjualan_bazars.barcode', '=', 'barang_masuks.barcode')
            ->get([
                'detail_penjualan_bazars.jumlah',
                'bazars.potongan',
                'barang_masuks.hjual',
            ]);

        $total_penjualan_bazar = 0;
        foreach ($daftar_penjualan_bazar as $value) {
            $total_penjualan_bazar += ($value->jumlah * ($value->hjual * $value->potongan));
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'biaya_toko' => $daftar_biaya_toko,
                'biaya_bazar' => $daftar_biaya_bazar,
                'penjualan_toko' => $total_penjualan_toko,
                'penjualan_bazar' => $total_penjualan_bazar,
            ],
        ], 200);
    }
}
