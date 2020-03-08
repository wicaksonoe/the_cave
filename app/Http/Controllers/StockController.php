<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Bazar;
use App\Detail_penjualan;

class StockController extends Controller
{
    public static function get_stock($barcode)
    {
        $barang = Barang_masuk::findOrFail($barcode);
        $original_data['barang_masuk'] = $barang;
        $original_data['jumlah'] = $barang->include_detail_barang()->sum('jumlah');



        $stock_asal = Barang_masuk::findOrFail($barcode)
            ->include_detail_barang()
            ->sum('jumlah');

        $stock_terjual_di_penjualan = Detail_penjualan::where('barcode', $barcode)
            ->sum('jumlah');

        $stock = [
            'stock_awal' => $stock_asal,
            'terjual_di_toko' => $stock_terjual_di_penjualan,
            'stock_sisa' => $stock_asal - $stock_terjual_di_penjualan
        ];

        return $stock_asal - $stock_terjual_di_penjualan;

        return response()->json([
            'original' => $original_data,
            'processed_data' => $stock
        ], 200);
    }
}
