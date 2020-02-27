<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $fillable = ['kode_trx', 'barcode', 'jumlah'];

    public function include_penjualan()
    {
        return $this->belongsTo('App\Penjualan', 'kode_trx', 'kode_trx');
    }

    public function include_barang_masuk()
    {
        return $this->belongsTo('App\Barang_masuk', 'barcode', 'barcode')->withTrashed();
    }
}
