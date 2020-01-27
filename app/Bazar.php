<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bazar extends Model
{
		use SoftDeletes;
		
		protected $fillable = [
			'nama_bazzar', 'alamat', 'tgl', 'potongan'
		];

		public function include_staff_bazar()
		{
			return $this->hasMany('App\Staff_bazar', 'id_bazar');
		}

		public function include_penjualan_bazar()
		{
			return $this->hasMany('App\Penjualan_bazar', 'id_bazar');
		}
}
