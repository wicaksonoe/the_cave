<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bazar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama_bazar', 'alamat', 'tgl_mulai', 'tgl_akhir', 'potongan'
    ];

    public function include_staff_bazar()
    {
        return $this->hasMany('App\Staff_bazar', 'id_bazar');
    }

    public function include_penjualan_bazar()
    {
        return $this->hasMany('App\Penjualan_bazar', 'id_bazar');
    }

    public function include_keluar_bazar()
    {
        return $this->hasMany('App\Keluar_bazar', 'id_bazar');
    }
}
