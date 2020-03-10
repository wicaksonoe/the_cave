<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'kode_trx';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['kode_trx', 'username'];

    public function include_user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function include_detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'kode_trx', 'kode_trx');
    }
}
