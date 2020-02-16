<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Http\Requests\BarangMasukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
	private $user;

	public function __construct()
	{
		$this->user = Auth::guard()->user();
	}

	public function get($barcode = null)
	{
        $data = [];

		if ($barcode == null) {
			// UPDATE USING YAJRA
            $data_barang = Barang_masuk::all();

            foreach ($data_barang as $key => $value) {
                $data[$key] = [
                    'barcode'         => $value->barcode,
                    'namabrg'         => $value->namabrg,
                    'jenis_barang'    => $value->include_jenis->nama_jenis,
                    'tipe_barang'     => $value->include_tipe->nama_tipe,
                    'supplier_barang' => $value->include_supplier->nama,
                    'jumlah'          => number_format($value->jumlah, 0, '.', ','),
                    'hpp'             => number_format($value->hpp, 0, '.', ','),
                    'hjual'           => number_format($value->hjual, 0, '.', ','),
                    'grosir'          => number_format($value->grosir, 0, '.', ','),
                    'partai'          => number_format($value->partai, 0, '.', ','),
                    'tgl'             => $value->tgl,
                ];
            }
            return DataTables::of($data)
                ->addColumn('aksi', function ($data_barang) {
                    $data_barang = (object) $data_barang;
                    return '<button class="btn btn-sm btn-info" value="'.$data_barang->barcode.'" onclick="editBarang(this.value)">Edit</button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
		} else {
			$data_barang = Barang_masuk::findOrFail($barcode);
		}

		return response()->json([
			'success' => true,
			'data' => $data_barang
		]);
	}

	public function create(BarangMasukRequest $request)
	{
		$validatedData = $request->validate([
			'barcode'  => 'string|unique:barang_masuks,barcode',
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
			'barcode'  => 'string',
		]);

		$barang = Barang_masuk::findOrFail($barcode);

		$barang->update([
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
			'message' => 'Data barang berhasil diubah'
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
