<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $datas = [
				'anak', 'bayi', 'balita', 'wanita', 'pria'
			];

			foreach ($datas as $data) {
				DB::table('jenis')->insert([
					'nama_jenis' => $data
				]);
			}
    }
}
