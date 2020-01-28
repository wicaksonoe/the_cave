<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$datas = [
			'blouse', 'rok', 'kemeja lengan panjang', 'gamis'
		];

		foreach ($datas as $data) {
			DB::table('tipes')->insert([
				'nama_tipe' => $data
			]);
		}
	}
}
