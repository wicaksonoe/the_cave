<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penjualan extends Model
{
    use SoftDeletes;

    protected $fillable = ['kode_trx', 'barcode', 'jumlah', 'harga_partai'];

    public function include_penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'kode_trx', 'kode_trx');
    }

    public function include_barang_masuk()
    {
        return $this->belongsTo(Barang_masuk::class, 'barcode', 'barcode')->withTrashed();
    }
}
