<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Staff_bazar;
use Faker\Generator as Faker;
use App\User;

$factory->define(Staff_bazar::class, function (Faker $faker) {
    return [
        'username' => User::inRandomOrder()->first()->username,
    ];
});
