<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only(['name', 'password']);
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function me(): \Illuminate\Http\JsonResponse
    {
        return response()->json(auth()->user());
    }
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }
    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
   
}
