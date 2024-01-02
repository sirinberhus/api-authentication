<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register'] ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($credentials)) {
            $user = \App\Models\User::find(Auth::user()->id);
            $user['token'] = $user->createToken('user_name')->accessToken;
            return response()->json([
                'user' => $user
            ], 200);
        }
        return response()->json([
            'massage' => 'invalid credentials'
        ], 402);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::Create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $token = $user->createToken('user_name')->accessToken;
        return response()->json([
            'message' => 'User registered successfully',
           // 'user' => $user,
            'token' => $token,
        ], 201);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Succesfully logged out',
        ]);

    }
}