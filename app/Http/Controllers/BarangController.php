<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Http\Requests\BarangMasukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
	private $user;

	public function __construct()
	{
		$this->user = Auth::guard()->user();
	}

	public function get($barcode = null)
	{
		if ($barcode == null) {
			// UPDATE USING YAJRA
			$data_barang = Barang_masuk::all();
		} else {
			$data_barang = Barang_masuk::find($barcode);
		}

		return response()->json([
			'success' => true,
			'data' => $data_barang
		]);
	}

	public function create(BarangMasukRequest $request)
	{
		$validatedData = $request->validate([
			'barcode'  => 'required|string|unique:barang_masuks,barcode',
		]);

		Barang_masuk::create($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Barang baru berhasil dimasukan'
		]);
	}

	public function update(BarangMasukRequest $request, $barcode)
	{
		$validatedData = $request->validate([
			'barcode'  => 'required|string',
		]);

		Barang_masuk::where('barcode', $barcode)
			->update([
				'namabrg'  => $request->namabrg,
				'id_jenis' => $request->id_jenis,
				'id_tipe'  => $request->id_tipe,
				'id_sup'   => $request->id_sup,
				'jumlah'   => $request->jumlah,
				'hpp'      => $request->hpp,
				'hjual'    => $request->hjual,
				'grosir'   => $request->grosir,
				'partai'   => $request->partai,
				'tgl'      => $request->tgl,
			]);

		return response()->json([
			'success' => true,
			'message' => 'Data barang berhasil diupdate'
		]);
	}

	public function delete($barcode)
	{
		$data = Barang_masuk::findOrFail($barcode);
		$data->delete();

		return response()->json([
			'success' => true,
			'message' => 'Data barang berhasil dihapus'
		]);
	}
}
