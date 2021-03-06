<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_barang extends Model
{
    use SoftDeletes;

    protected $fillable = ['barcode_barang', 'jumlah'];

    public function include_barang_masuk()
    {
        return $this->belongsTo(Barang_masuk::class, 'barcode_barang', 'barcode');
    }
}
