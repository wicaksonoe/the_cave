<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_penjualan_bazar extends Model
{
    use SoftDeletes;

    protected $fillable = ['kode_trx', 'barcode', 'jumlah'];

    public function include_penjualan_bazar()
    {
        return $this->belongsTo(Penjualan_bazar::class, 'kode_trx', 'kode_trx');
    }
}
