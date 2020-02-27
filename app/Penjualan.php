<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $primaryKey = 'kode_trx';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['kode_trx', 'username'];

    public function include_user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }

    public function include_detail_penjualan()
    {
        return $this->hasMany('App\DetailPenjualan', 'kode_trx', 'kode_trx');
    }
}