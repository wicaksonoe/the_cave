<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class APIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->middleware('isRoleAdmin', ['except' => ['login', 'logout', 'check']]);
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

        $data['user'] = $user;

        if ($user->role != 'admin') {
            $result = User::where('username', $user->username)
                ->first()
                ->include_staff_bazar()
                ->first();

            if ($result) {
                $data['id_bazar'] = $result->include_bazar->id;
            } else {
                $data['id_bazar'] = '';
            }
        } else {
            $data['id_bazar'] = '';
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
