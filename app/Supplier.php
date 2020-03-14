<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'nama_supplier', 'alamat', 'no_telp',
	];

	public function include_barang_masuk()
	{
		return $this->hasMany(Barang_masuk::class, 'id_sup');
	}
}
