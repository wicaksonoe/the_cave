<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keluar_bazar extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'id_bazar', 'barcode',
    ];

    public function include_bazar()
	{
		return $this->belongsTo('App\Bazar', 'id_bazar')->withTrashed();
	}

	public function include_barang_masuk()
	{
		return $this->belongsTo('App\Barang_masuk', 'barcode', 'barcode');
	}
}
