<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_keluar_bazar extends Model
{
    use SoftDeletes;

    protected $fillable = ['id_keluar_bazar', 'jumlah'];

    public function include_keluar_bazar()
    {
        return $this->belongsTo('App\Keluar_bazar', 'id_keluar_bazar', 'id');
    }
}
