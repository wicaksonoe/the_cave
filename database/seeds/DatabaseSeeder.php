<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            JenisSeeder::class,
            TipeSeeder::class,
            UserSeeder::class,
            BarangSeeder::class,
            PenjualanSeeder::class,
            BazarSeeder::class,
            BiayaSeeder::class,
        ]);
    }
}
