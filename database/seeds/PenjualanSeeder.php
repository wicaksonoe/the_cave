<?php

use App\Detail_penjualan;
use App\Penjualan;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Penjualan::class, 5)->create()->each(function ($detail) {
            $detail->include_detail_penjualan()->saveMany( factory(Detail_penjualan::class, 3)->make() );
        });
    }
}
