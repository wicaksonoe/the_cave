<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Barang_masuk;
use App\Detail_penjualan;
use Faker\Generator as Faker;

$factory->define(Detail_penjualan::class, function (Faker $faker) {
    return [
        'barcode'      => Barang_masuk::all()->random()->barcode,
        'jumlah'       => $faker->numberBetween(2, 20),
        'harga_partai' => (string) $faker->numberBetween(0, 1),
    ];
});
