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
        return $this->hasMany(Staff_bazar::class, 'id_bazar');
    }

    public function include_penjualan_bazar()
    {
        return $this->hasMany(Penjualan_bazar::class, 'id_bazar', 'id');
    }

    public function include_keluar_bazar()
    {
        return $this->hasMany(Keluar_bazar::class, 'id_bazar');
    }

    public function include_biaya()
    {
        return $this->hasMany(Biaya::class, 'id_bazar');
    }
}
