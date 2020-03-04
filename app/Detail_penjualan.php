<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penjualan extends Model
{
    use SoftDeletes;

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
