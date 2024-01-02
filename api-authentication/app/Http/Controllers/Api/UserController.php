<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function me()
    {
        $user = Auth::user();
        return response()->json([
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'id' => $user->id,
        ]);
    }
}