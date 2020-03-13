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
		return $this->belongsTo(Bazar::class, 'id_bazar');
	}

	public function include_user()
	{
		return $this->belongsTo(User::class, 'username', 'username');
	}
}
