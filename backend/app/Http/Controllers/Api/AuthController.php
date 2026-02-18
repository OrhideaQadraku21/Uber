<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'rider',
        ]);

        $token = JWTAuth::fromUser($user);;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in_seconds' => (int) config('jwt.ttl') * 60,
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Email ose password gabim.'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in_seconds' => (int) config('jwt.ttl') * 60,
            'user' => auth('api')->user(),
        ]);
    }

    public function me()
{
    return response()->json(auth('api')->user());
}


    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());;
        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in_seconds' => JWTAuth::factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }
}
