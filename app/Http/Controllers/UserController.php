<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
	private $user;

	public function __construct()
	{
		$this->user = Auth::guard()->user();
		$this->middleware('isRoleAdmin');
	}

	public function get($username = null)
	{
		if ($username === null) {
			return DataTables::of(User::all())
				->addColumn('aksi', function ($data) {
					return '<button class="btn btn-sm btn-info" value="'.$data->username.'" onclick="editUser(this.value)">Edit</button>';
				})
				->rawColumns(['aksi'])
				->make(true);
		} else {
			$data_user = User::findOrFail($username);

			return response()->json([
				'success' => true,
				'data' => $data_user
			]);
		}
	}

	public function create(RegistrationFormRequest $request)
	{
		$validateRequest = $request->validate([
			'username' => 'bail|unique:users,username'
		]);

		User::create(
			[
				'username' => $request->username,
				'password' => Hash::make($request->password),
				'nama'     => $request->nama,
				'alamat'   => $request->alamat,
				'telp'     => $request->telp,
				'role'     => $request->role,
			]
		);

		return response()->json([
			'success' => true,
			'message' => 'Registrasi berhasil'
		]);
	}

	public function update(RegistrationFormRequest $request, $username)
	{
		$data_user = User::findOrFail($username);

		$data_user->update([
			'username' => $request->username,
			'password' => Hash::make($request->password),
			'nama'     => $request->nama,
			'alamat'   => $request->alamat,
			'telp'     => $request->telp,
			'role'     => $request->role,
		]);

		return response()->json([
			'succeess' => true,
			'message' => 'Data user berhasl diubah.'
		]);
	}
}
