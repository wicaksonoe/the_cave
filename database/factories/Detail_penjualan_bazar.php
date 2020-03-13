<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Barang_masuk;
use App\Detail_penjualan_bazar;
use Faker\Generator as Faker;

$factory->define(Detail_penjualan_bazar::class, function (Faker $faker) {
    return [
        'barcode'      => Barang_masuk::inRandomOrder()->first()->barcode,
        'jumlah'       => $faker->numberBetween(2, 20),
    ];
});
