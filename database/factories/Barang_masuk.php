<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Barang_masuk;
use Faker\Generator as Faker;

$factory->define(Barang_masuk::class, function (Faker $faker) {
    return [
        'barcode'  => '00'.$faker->ean13,
        'namabrg'  => $faker->name(),
        'id_jenis' => $faker->numberBetween(1, 4),
        'id_tipe'  => $faker->numberBetween(1, 4),
        'hpp'      => $faker->numberBetween(100000, 1000000),
        'hjual'    => $faker->numberBetween(100000, 1000000),
        'grosir'   => $faker->numberBetween(100000, 1000000),
        'partai'   => $faker->numberBetween(100000, 1000000),
    ];
});
