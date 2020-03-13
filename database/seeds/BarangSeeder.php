<?php

use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Supplier::class, 5)->create()->each(function ($supplier) {
            $supplier->include_barang_masuk()->saveMany( factory(App\Barang_masuk::class, 10)->make()->each(function ($barang_masuk) {
                $barang_masuk->include_detail_barang()->saveMany( factory(App\Detail_barang::class, 3)->make() );
            }) );
        });
    }
}
