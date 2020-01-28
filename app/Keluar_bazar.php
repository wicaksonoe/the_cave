<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keluar_bazar extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'id_bazar', 'date', 'barcode', 'jml',
	];
}
