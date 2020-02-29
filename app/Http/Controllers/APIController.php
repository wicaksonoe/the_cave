<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\CreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['login', 'register']]);
	}

	protected function respondWithToken($token)
	{
        return response()
        ->json([
            'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => $this->guard()->factory()->getTTL() * 60
			])
        ->cookie('access_token', $token, 60);
	}

	public function guard()
	{
		return Auth::guard();
	}

	public function login(Request $request)
	{
		$credentials = $request->only(['username', 'password']);

		if ($token = $this->guard()->attempt($credentials)) {
			return $this->respondWithToken($token);
		}

		return response()->json([
			'success' => false,
			'message' => 'Unauthorized'
		], 401);
	}

	public function logout()
	{
		$this->guard()->logout();

		return response()->json([
			'success' => true,
			'message' => 'Berhasil logout.'
		]);
	}

	public function register(CreateRequest $request)
	{
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
}
