<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Detail_barang;
use Faker\Generator as Faker;

$factory->define(Detail_barang::class, function (Faker $faker) {
    return [
        'jumlah' => $faker->numberBetween(10, 100)
    ];
});
