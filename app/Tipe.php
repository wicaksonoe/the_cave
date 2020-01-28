<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipe extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'nama_tipe'
	];

	public function include_barang_masuk()
	{
		return $this->hasMany('App\Barang_masuk', 'id_tipe');
	}
}
