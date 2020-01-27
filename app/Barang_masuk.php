<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang_masuk extends Model
{
	use SoftDeletes;

	protected $primaryKey = 'barcode';
	protected $keyType = 'string';
	public $incrementing = false;

	protected $fillable = [
		'barcode', 'namabrg', 'id_jenis', 'id_tipe', 'id_sup', 'jumlah', 'hpp', 'hjual', 'grosir', 'partai', 'tgl',
	];

	public function include_penjualan_bazar()
	{
		return $this->hasMany('App\Penjualan_bazar', 'barcode', 'barcode');
	}

	public function include_suplier()
	{
		return $this->belongsTo('App\Suplier', 'id_sup');
	}

	public function include_tipe()
	{
		return $this->belongsTo('App\Tipe', 'id_tipe');
	}

	public function include_jenis()
	{
		return $this->belongsTo('App\Jenis', 'id_jenis');
	}
}
