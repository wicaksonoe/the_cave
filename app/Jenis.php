<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'nama_jenis'
	];

	public function include_barang_masuk()
	{
		return $this->hasMany(Barang_masuk::class, 'id_jenis');
	}
}
