<?php

use Illuminate\Database\Seeder;

class PenjualanBazarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Penjualan_bazar::class, 3)->create()->each(function ($data) {
            $data->include_detail_penjualan_bazar()->saveMany(
                factory(App\Detail_penjualan_bazar::class, 2)->make()
            );
        });
    }
}
