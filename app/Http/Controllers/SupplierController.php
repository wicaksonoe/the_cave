<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\CreateRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Supplier;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function create(CreateRequest $request)
    {
        $existing_supplier = Supplier::where('nama_supplier', $request->nama_supplier)->first();

        if ($existing_supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Nama supplier sudah terdaftar.',
            ], 422);
        }

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

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
                        <button class="btn btn-sm btn-info" value="' . $data_supplier->id . '" onclick="editSupplier(this.value)">Edit</button>
                        <button class="btn btn-sm btn-danger" value="' . $data_supplier->id . '" onclick="deleteSupplier(this.value)" style="margin-left:1rem">Hapus</button>
                        ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $data_supplier = Supplier::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $data_supplier
            ]);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat'        => $request->alamat,
            'no_telp'       => $request->no_telp,
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
