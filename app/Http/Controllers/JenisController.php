<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Jenis;


class JenisController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::guard()->user();
        $this->middleware('isRoleAdmin');
    }

    public function create(Request $request)
    {
        $rules = [
            'data' => 'bail|required|string'
        ];

        $messages = [
            'data.required' => 'Kolom tidak boleh kosong',
            'data.string' => 'Kolom tidak boleh kosong'
        ];

        Validator::make($request->all(), $rules, $messages);

        $existing_data = Jenis::where('nama_jenis', $request->data)->first();

        if (!$existing_data) {
            Jenis::create([
                'nama_jenis' => $request->data
            ]);

            return response()->json([
                'success' => false,
                'message' => "Data berhasil ditambahkan.",
                'data' => Jenis::all()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Data sudah ada. Tidak dapat menambahkan."
            ], 422);
        }
    }
}
