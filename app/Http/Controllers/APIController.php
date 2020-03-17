<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['login']]);
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
        ], 200);
	}

	public function check(Request $request)
	{
        $user = $this->guard()->user();

        return response()->json([
			'success' => true,
			'data' => $user
		], 200);
	}
}
