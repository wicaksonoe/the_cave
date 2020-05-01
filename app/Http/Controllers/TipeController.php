<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Tipe;

class TipeController extends Controller
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

        $existing_data = Tipe::where('nama_tipe', $request->data)->first();

        if (!$existing_data) {
            Tipe::create([
                'nama_tipe' => $request->data
            ]);

            return response()->json([
                'success' => false,
                'message' => "Data berhasil ditambahkan.",
                'data' => Tipe::all()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Data sudah ada. Tidak dapat menambahkan."
            ], 422);
        }
    }
}
