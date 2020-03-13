<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Keluar_bazar;
use App\Barang_masuk;
use Faker\Generator as Faker;

$factory->define(Keluar_bazar::class, function (Faker $faker) {
    return [
        'barcode' => Barang_masuk::inRandomOrder()->first()->barcode,
        'jumlah' => $faker->numberBetween(2, 10)
    ];
});
