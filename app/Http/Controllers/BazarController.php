<?php

namespace App\Http\Controllers;

use App\Bazar;
use App\Http\Requests\BazarRequest;
use App\Http\Requests\KeluarBazzarRequest;
use App\Staff_bazar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BazarController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function create(BazarRequest $request)
    {
        Bazar::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bazar baru berhasil dibuat.'
        ]);
    }

    public function get($id = null)
    {
        if ($id == null) {
            # REPLACE WITH YAJRA
            $bazar = Bazar::all();
        } else {
            $bazar = Bazar::findOrFail($id);
        }

        return response()->json([
            'success' => true,
            'data' => $bazar,
        ]);
    }

    public function update(BazarRequest $request, $id)
    {
        $bazar = Bazar::findOrFail($id);

        $bazar->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data bazar berhasil diubah.'
        ]);
    }

    public function delete($id)
    {
        $bazar = Bazar::findOrFail($id);

        $bazar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data bazar berhasil dihapus.'
        ]);
    }

    public function create_staff(Request $request, $id_bazzar)
    {
        $data_bazzar = Bazar::find($id_bazzar);

        $validateRequest = $request->validate([
            'username' => 'required|string'
        ]);

        Staff_bazar::create([
            'id_bazar' => $id_bazzar,
            'username' => $request->username
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Staff bazzar ' . $data_bazzar->nama_bazar . ' berhasil ditambahkan.'
        ]);
    }

    public function get_staff($id_bazzar)
    {
        $data_staff_bazzar = Staff_bazar::where(['id_bazar' => $id_bazzar])->get();

        return DataTables::of($data_staff_bazzar)
            ->addColumn('nama_pegawai', function ($data) {
                return $data->include_user->nama;
            })
            ->addColumn('action', function ($data) {
                return null;
            })
            ->rawColumns(['nama_pegawai', 'action'])
            ->make(true);
    }

    public function delete_staff($id_bazzar, $username)
    {
        $data_staff = Staff_bazar::where([
            'id_bazar' => $id_bazzar,
            'username' => $username
        ])->first();

        if ($data_staff) {
            $data_staff->delete();

            return response()->json([
                'success' => true,
                'message' => 'Staff bazzar berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Staff bazzar tidak ditemukan atau sudah terhapus.'
            ], 404);
        }
    }

    public function create_barang(KeluarBazzarRequest $request, $id_bazzar)
    {
        # code...
    }

    public function get_barang($id_bazzar, $id = null)
    {
        # code...
    }

    public function update_barang(KeluarBazzarRequest $request, $id_bazzar, $id)
    {
        # code...
    }

    public function delete_barang($id_bazzar, $id)
    {
        # code...
    }
}
