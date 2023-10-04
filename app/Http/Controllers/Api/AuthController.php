<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //




    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'message' => 'email atau password salah'
            ], 400);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'status' => 'true',
            'message' => 'Anda berhasil login',
            'user' => Auth::user(),
            'token' => $token
        ], 200);
    }
}
