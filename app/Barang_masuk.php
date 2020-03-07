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
		'barcode', 'namabrg', 'id_jenis', 'id_tipe', 'id_sup', 'hpp', 'hjual', 'grosir', 'partai',
	];

	public function include_penjualan_bazar()
	{
		return $this->hasMany('App\Penjualan_bazar', 'barcode', 'barcode');
	}

	public function include_keluar_bazar()
	{
		return $this->hasMany('App\Keluar_bazar', 'barcode', 'barcode');
	}

	public function include_supplier()
	{
		return $this->belongsTo('App\Supplier', 'id_sup')->withTrashed();
	}

	public function include_tipe()
	{
		return $this->belongsTo('App\Tipe', 'id_tipe')->withTrashed();
	}

	public function include_jenis()
	{
		return $this->belongsTo('App\Jenis', 'id_jenis')->withTrashed();
    }

    public function include_detail_barang()
    {
        return $this->hasMany('App\Detail_barang', 'barcode_barang', 'barcode');
    }
}
