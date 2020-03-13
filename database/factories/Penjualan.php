<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Penjualan;
use App\User;
use Faker\Generator as Faker;

$factory->define(Penjualan::class, function (Faker $faker) {
    return [
        'kode_trx' => 'TRX-STR-' . str_pad((string) $faker->numberBetween(1, 99999), 6, "0", STR_PAD_LEFT),
        'username' => User::inRandomOrder()->first()->username,
    ];
});
