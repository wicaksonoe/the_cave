<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff_bazar extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'id_bazar', 'username'
	];

	public function include_bazar()
	{
		return $this->belongsTo('App\Bazar', 'id_bazar');
	}

	public function include_user()
	{
		return $this->belongsTo('App\User', 'username', 'username');
	}
}
