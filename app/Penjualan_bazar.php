<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan_bazar extends Model
{
	use SoftDeletes;

    protected $primaryKey = 'kode_trx';
    protected $keyType = 'string';
    public $incrementing = false;

	protected $fillable = [
		'kode_trx', 'id_bazar', 'username',
	];

	public function include_bazar()
	{
		return $this->belongsTo(Bazar::class, 'id_bazar');
    }

    public function include_user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function include_detail_penjualan_bazar()
    {
        return $this->hasMany(Detail_penjualan_bazar::class, 'kode_trx', 'kode_trx');
    }
}
