<?php

namespace App\Http\Controllers;

use App\Bazar;
use App\Http\Requests\BazarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
