<?php

use Illuminate\Database\Seeder;

class BazarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Bazar::class, 5)->create()->each(function ($bazar) {
            $bazar->include_biaya()->saveMany(
                factory(App\Biaya::class, 3)->make()
            );
            $bazar->include_keluar_bazar()->saveMany(
                factory(App\Keluar_bazar::class, 2)->make()
            );
            $bazar->include_staff_bazar()->saveMany(
                factory(App\Staff_bazar::class, 2)->make()
            );
        });
    }
}
