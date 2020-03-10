<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biaya extends Model
{
    use SoftDeletes;

    protected $fillable = ['id_bazar', 'keterangan', 'nominal'];

    public function include_bazar()
    {
        return $this->belongsTo(Bazar::class, 'id_bazar', 'id');
    }
}
