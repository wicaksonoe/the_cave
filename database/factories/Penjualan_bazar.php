<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bazar;
use App\User;
use App\Penjualan_bazar;
use Faker\Generator as Faker;

$factory->define(Penjualan_bazar::class, function (Faker $faker) {
    $id_bazar = Bazar::inRandomOrder()->first()->id;
    $prefix_bazar = str_pad($id_bazar, 3, '0', STR_PAD_LEFT);

    return [
        'kode_trx' => 'TRX-BZR-' . $prefix_bazar . '-' . str_pad((string) $faker->numberBetween(1, 99999), 6, "0", STR_PAD_LEFT),
        'username' => User::inRandomOrder()->first()->username,
        'id_bazar' => $id_bazar,
    ];
});
