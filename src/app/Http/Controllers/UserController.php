<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|min:6|max:32',
            'password' => 'required|string|min:6|max:32',
        ]);

        $token = auth()->attempt($validatedData);

        if ($token) {

            $user = auth()->user();
            // $token = $user->createToken('authToken')->plainTextToken;
            return $this->respondWithToken($token, $user);
            // return response()->json([
            //     'status' => 'OK',
            //     'code' => 200,
            //     'data' => $user,
            //     // 'token' => $token,
            //     'token_type' => 'bearer',
            // ], 200);
        } else {

            return response()->json([
                'status' => 'failed',
                'code' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }

    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'data' => $user,
            'token' => $token,
            'token_type' => 'bearer',
        ], 200);
    }

}
