<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
		use Notifiable;
		use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'nama', 'alamat', 'telp', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
		
		public function getJWTIdentifier()
		{
			return $this->getKey();
		}

		public function getJWTCustomClaims()
		{
			return [];
		}

		public function include_staff_bazar()
		{
			return $this->hasMany('App\Staff_bazar', 'username', 'username');
		}
}
