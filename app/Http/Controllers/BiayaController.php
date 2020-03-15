<?php

namespace App\Http\Controllers;

use App\Bazar;
use App\Biaya;
use App\Http\Requests\Biaya\Bazar\CreateRequest as BazarCreateRequest;
use App\Http\Requests\Biaya\Bazar\UpdateRequest as BazarUpdateRequest;
use App\Http\Requests\Biaya\CreateRequest;
use App\Http\Requests\Biaya\UpdateRequest;
use Yajra\DataTables\Facades\DataTables;

class BiayaController extends Controller
{
    public function get($id = null)
    {
        if ($id == null) {
            $data_biaya = Biaya::all();

            return DataTables::of($data_biaya)
                ->addColumn('aksi', function ($biaya) {
                    return $biaya->id . 'Button here';
                })
                ->addColumn('nama_bazar', function($biaya) {
                    if ($biaya->id_bazar == null) {
                        return '--Toko--';
                    } else {
                        return $biaya->include_bazar()->withTrashed()->first()->nama_bazar;
                    }
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $data_biaya = Biaya::find($id);

            return response()->json([
                'success' => true,
                'data' => $data_biaya
            ], 200);
        }
    }

    public function create(CreateRequest $request)
    {
        Biaya::create([
            'keterangan' => $request->keterangan,
            'nominal'    => $request->nominal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Biaya berhasil ditambahkan'
        ], 200);
    }

    public function update(UpdateRequest $request, $id)
    {
        $biaya = Biaya::findOrFail($id);

        Biaya::create([
            'keterangan' => $request->keterangan,
            'nominal'    => $request->nominal,
        ]);

        $biaya->delete();

        return response()->json([
            'success' => true,
            'message' => 'Biaya berhasil disesuaikan'
        ], 200);
    }

    public function delete($id)
    {
        $biaya = Biaya::findOrFail($id);

        $biaya->delete();

        return response()->json([
            'success' => true,
            'message' => 'Biaya berhasil dihapus'
        ], 200);
    }

    public function get_biaya_bazar($id_bazar, $id = null)
    {
        $bazar = Bazar::findOrFail($id_bazar);

        if ($id == null) {
            $daftar_biaya_bazar = $bazar->include_biaya()->get();

            return DataTables::of($daftar_biaya_bazar)
                ->addColumn('aksi', function ($biaya_bazar) {
                    return $biaya_bazar->id . 'Button here';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $biaya_bazar = $bazar->include_biaya()->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $biaya_bazar
            ], 200);
        }
    }

    public function create_biaya_bazar($id_bazar, BazarCreateRequest $request)
    {
        $bazar = Bazar::findOrFail($id_bazar);

        $bazar->include_biaya()->create([
            'keterangan' => $request->keterangan,
            'nominal'    => $request->nominal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Biaya bazar ' . $bazar->nama_bazar . ' berhasil ditambahkan'
        ], 200);
    }

    public function update_biaya_bazar($id_bazar, BazarUpdateRequest $request, $id)
    {
        $bazar = Bazar::findOrFail($id_bazar);

        $biaya_bazar_existing = $bazar
            ->include_biaya()
            ->findOrFail($id);

        $bazar->include_biaya()->create([
            'keterangan' => $request->keterangan,
            'nominal'    => $request->nominal,
        ]);

        $biaya_bazar_existing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Biaya bazar ' . $bazar->nama_bazar . ' berhasil disesuaikan'
        ], 200);
    }

    public function delete_biaya_bazar($id_bazar, $id)
    {
        $bazar = Bazar::findOrFail($id_bazar);

        $biaya_bazar_existing = $bazar
            ->include_biaya()
            ->findOrFail($id);

        $biaya_bazar_existing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Biaya bazar ' . $bazar->nama_bazar . ' berhasil dihapus'
        ], 200);
    }
}
