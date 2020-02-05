<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
	private $user;

	public function __construct()
	{
		$this->user = Auth::guard()->user();
	}

	public function create(SupplierRequest $request)
	{
		$validatedRequest = $request->validate([
			'nama' => 'string|unique:suppliers,nama'
		]);

		Supplier::create($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Supplier berhasil ditambahkan'
		]);
	}

	public function get($id = null)
	{
		if ($id == null) {
			# REPLACE WITH YAJRA
            $data_supplier = Supplier::all();

            return DataTables::of($data_supplier)
                ->addColumn('aksi', function ($data_supplier) {
                    return '
                        <button class="btn btn-sm btn-info" value="{$data_supplier->id}" onclick="editBarangKeluar(this.value)">Edit</button>
                        <button class="btn btn-sm btn-danger" value="{$data_supplier->id}" onclick="deleteBarangKeluar(this.value) style="margin-left:1rem">Hapus</button>
                        ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
		} else {
			$data_supplier = Supplier::findOrFail($id);
		}

		return response()->json([
			'success' => true,
			'data' => $data_supplier
		]);
	}

	public function update(SupplierRequest $request, $id)
	{
		$validatedRequest = $request->validate([
			'nama' => 'required|string'
		]);

		$supplier = Supplier::findOrFail($id);

		$supplier->update([
			'nama'   => $request->nama,
			'alamat' => $request->alamat,
			'telp'   => $request->telp,
		]);

		return response()->json([
			'success' => true,
			'message' => 'Data supplier berhasil diubah'
		]);
	}

	public function delete($id)
	{
		$supplier = Supplier::findOrFail($id);
		$supplier->delete();

		return response()->json([
			'success' => true,
			'message' => 'Data supplier berhasil dihapus'
		]);
	}
}
