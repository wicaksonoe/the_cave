<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Biaya;
use Faker\Generator as Faker;

$factory->define(Biaya::class, function (Faker $faker) {
    return [
        'keterangan' => $faker->text(100),
        'nominal'    => $faker->numberBetween(10000, 500000),
    ];
});
