<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function username()
    {
        return 'username';
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|min:6|max:25|unique:users',
            'country_code' => 'required|string|max:4',
            'password' => 'required|string|min:4|max:25',
            'accept_consent' => 'required|boolean'
        ]);

        try {
            $user = User::create($validatedData);
            $token = auth()->login($user);
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'code' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|min:6|max:32',
            'password' => 'required|string|min:6|max:32',
        ]);

        //return auth::guard('api')->check();

        //if (!auth()->check()) {
        $token = auth()->attempt($validatedData);

        // if (auth()->attempt($validatedData)) {
        if ($token) {
            $user = auth()->user();
            // $token = $user->createToken('authToken')->plainTextToken;
            return $this->respondWithToken($token, $user);
        } else {
            return response()->json([
                'status' => 'failed',
                'code' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }
        // } else {
        //     return response()->json([
        //         'status' => 'already login',
        //         'message' => 'You are already login',
        //     ], 200);
        // }
    }
    public function me()
    {
        $user = auth()->user();
        $user = $user->toArray();
        $user['bet'] = 2;
        $user['losses'] = 1;
        $user['wagered'] = 500;
        $user['profit'] = 20;
        $user['max_profit'] = 400;

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'user' => $user,
        ]);
    }

    public function updateme(Request $request)
    {
        $validatedData = $request->validate([
            'avatar' => 'required|string|max:100',
            'name' => 'required|string|max:100',
        ]);

        $user = auth()->user();
        $user->update($validatedData);

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'data' => $user,
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required|string|min:6'
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'code' => 422,
                'message' => [
                    'current_password' => 'Current password is incorrect',
                ],
            ], 422);
        }

        // Update new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'user' => $user,
        ], 200);
    }

    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'message' => 'Logged out successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
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
