<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Bazar;
use App\Detail_penjualan;

class StockController extends Controller
{
    public static function get_stock($barcode)
    {
        // menghitung jumlah stock dari data barang_masuk
        $stock_asal = Barang_masuk::findOrFail($barcode)
            ->include_detail_barang()
            ->sum('jumlah');

        // menghitung jumlah barang yang terjual di toko
        $stock_terjual_di_penjualan = Detail_penjualan::where('barcode', $barcode)
            ->sum('jumlah');

        // menghitung jumlah barang yang dikirim ke bazar aktif
        $data_bazar_aktif = Bazar::get();

        $stock_di_bazar = 0;
        foreach ($data_bazar_aktif as $bazar) {
            $stock_di_bazar += $bazar
                ->include_keluar_bazar()
                ->where('barcode', $barcode)
                ->sum('jumlah');
        }

        // menghitung jumlah barang yang terjual di bazar tidak aktif
        $daftar_bazar_non_aktif = Bazar::onlyTrashed()->get();

        $stock_terjual_di_bazar_non_aktif = 0;
        foreach ($daftar_bazar_non_aktif as $bazar_non_aktif) {
            $daftar_transaksi = $bazar_non_aktif->include_penjualan_bazar()->get();

            foreach ($daftar_transaksi as $transaksi) {
                $stock_terjual_di_bazar_non_aktif += $transaksi
                    ->include_detail_penjualan_bazar()
                    ->where('barcode', $barcode)
                    ->sum('jumlah');
            }
        }

        return $stock_asal - $stock_terjual_di_penjualan - $stock_di_bazar - $stock_terjual_di_bazar_non_aktif;

        /*
         * Below is the code for
         * debug and experiment only
         *
         *

        $barang = Barang_masuk::findOrFail($barcode);
        $original_data['barang_masuk'] = $barang;
        $original_data['jumlah'] = $barang->include_detail_barang()->sum('jumlah');

        $stock = [
            'stock_awal' => $stock_asal,
            'terjual_di_toko' => $stock_terjual_di_penjualan,
            'stock_di_bazar' => $stock_di_bazar,
            'terjual_di_bazar' => $stock_terjual_di_bazar_non_aktif,
            'stock_sisa' => $stock_asal - $stock_terjual_di_penjualan - $stock_di_bazar - $stock_terjual_di_bazar_non_aktif
        ];

        return response()->json([
            'original' => $original_data,
            'processed_data' => $stock
        ], 200);

        */
    }

    public static function validate_stock($barcode, $requested_stock)
    {
        $ready_stock = self::get_stock($barcode);

        if ($ready_stock - $requested_stock >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_stock_for_bazar($id_bazar, $barcode)
    {
        $bazar = Bazar::findOrFail($id_bazar);
        $stock_barang = $bazar
            ->include_keluar_bazar()
            ->where('barcode', $barcode)
            ->sum('jumlah');

        $stock_terjual = $bazar
            ->include_detail_penjualan_bazar()
            ->where('barcode', $barcode)
            ->sum('jumlah');

        return $stock_barang - $stock_terjual;
    }

    public static function validate_stock_for_bazar($id_bazar, $barcode, $requested_stock)
    {
        $ready_stock = self::get_stock_for_bazar($id_bazar, $barcode);

        if ($ready_stock - $requested_stock >= 0) {
            return true;
        } else {
            return false;
        }
    }
}
