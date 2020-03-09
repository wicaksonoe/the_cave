<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bazar;
use Faker\Generator as Faker;

$factory->define(Bazar::class, function (Faker $faker) {
    return [
        'nama_bazar' => $faker->text(50),
        'alamat'     => $faker->address,
        'tgl_mulai'  => $faker->dateTimeThisMonth,
        'tgl_akhir'  => $faker->dateTimeThisMonth,
        'potongan'   => $faker->numberBetween(10000, 50000),
    ];
});
