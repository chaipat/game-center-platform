<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\TransactionsGame;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    public function username()
    {
        return 'username';
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="User registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "name", "country_code", "password", "accept_consent"},
     *             @OA\Property(property="username", type="string", minLength=6, maxLength=25, example="user111"),
     *             @OA\Property(property="name", type="string", minLength=4, maxLength=25, example="myname"),
     *             @OA\Property(property="country_code", type="string", maxLength=4, example="+66"),
     *             @OA\Property(property="password", type="string", minLength=4, maxLength=25, example="123456"),
     *             @OA\Property(property="accept_consent", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registration successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Registration failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|min:6|max:25|unique:users',
            'country_code' => 'required|string|max:4',
            'password' => 'required|string|min:4|max:25',
            'accept_consent' => 'required|boolean'
        ]);

        try {
            $validatedData['name'] = $validatedData['username'];
            $validatedData['status'] = 'Active';
            $validatedData['uuid'] = $this->guidv4();
            $validatedData['role'] = 'User';

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
                'status' => 'ERROR',
                'code' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "password"},
     *             @OA\Property(property="username", type="string", minLength=6, maxLength=32, example="user03"),
     *             @OA\Property(property="password", type="string", minLength=6, maxLength=32, example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="data", type="json"),
     *             @OA\Property(property="token", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|min:6|max:32',
            'password' => 'required|string|min:6|max:32',
        ]);

        $validatedData['status'] = 'Active';

        $token = auth()->attempt($validatedData);

        if ($token) {
            $user = auth()->user();
            UserLog::createLog($user->id, 'Login');
            return $this->respondWithToken($token, $user);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'code' => 401,
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     summary="Retrieve current user details",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User details retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function me()
    {
        $user = auth()->user();
        $user['bet'] = TransactionsGame::sum('bet');
        $user['win'] = TransactionsGame::sum('win');
        $user['losses'] = TransactionsGame::sum('losses');
        $user['wagered'] = TransactionsGame::sum('amount');
        $user['profit'] = TransactionsGame::sum('profit');
        $user['max_profit'] = TransactionsGame::max('profit');

        $user['avatar'] = env('IMAGE_URL') . '/' . $user['avatar'];

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'data' => $user,
        ]);
    }


    /**
     * @OA\Put(
     *     path="/api/auth/updateme",
     *     summary="Update user details",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", minLength=6, maxLength=25),
     *             @OA\Property(property="mobile_number", type="string", maxLength=20),
     *             @OA\Property(property="contact", type="string", maxLength=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function updateme(Request $request)
    {
        try {
            $user = auth()->user();

            $validatedData = $request->validate([
                'name' => 'string|min:6|max:25|unique:users,name,' . $user->id,
                'mobile_number' => 'string|max:20',
                'contact' => 'string|max:15',
            ]);

            $user->update($validatedData);

            $user['avatar'] = env('IMAGE_URL') . '/' . $user['avatar'];

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/change-password",
     *     summary="Change user password",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="new_password", type="string", minLength=6),
     *             @OA\Property(property="new_password_confirmation", type="string", minLength=6)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password changed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required|string|min:6'
        ]);

        $user = auth()->user();

        // Update new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'user' => $user,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        try {
            UserLog::createLog(auth()->user()->id, 'Logout');
            auth('api')->logout();
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'message' => 'Logged out successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/check-token",
     *     summary="Check token validity",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token validity checked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string"),
     *                 @OA\Property(property="exp_timestamp", type="integer"),
     *                 @OA\Property(property="exp", type="string"),
     *                 @OA\Property(property="game", type="string"),
     *                 @OA\Property(property="activity", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function checkToken(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $decodedToken = JWT::decode($token, new Key(env('JWT_SECRET'), env('JWT_ALGO')));
            $expirationTime = $decodedToken->exp;
            $expirationDate = date("Y-m-d H:i:s", $expirationTime);

            // Get last activity log
            $log = ActivityLog::where('user_id', $decodedToken->sub)->latest()->first();

            if ($log) {
                $game = $log->game->name;
                $activity = $log->activity;
            } else {
                $game = '';
                $activity = '';
            }

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => [
                    'token' => $token,
                    'exp_timestamp' => $expirationTime,
                    'exp' => $expirationDate,
                    'game' => $game,
                    'activity' => $activity,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/set-password",
     *     summary="Set user password",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="username", type="string", minLength=6, maxLength=25),
     *             @OA\Property(property="password", type="string", minLength=4, maxLength=25),
     *             @OA\Property(property="ref_code", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password set successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or username not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function setPassword(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|min:6|max:25',
            'password' => 'required|string|min:4|max:25',
            'ref_code' => 'required|string'
        ]);

        $user = User::where('username', $validatedData['username'])->first();

        if ($user) {
            $user->update([
                'password' => bcrypt($validatedData['password']),
                'ref_code' => $validatedData['ref_code']
            ]);

            UserLog::createLog($user->id, 'Set password');

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'code' => 422,
                'message' => 'Username not found',
            ], 422);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/check-username",
     *     summary="Check if username is available",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="username", type="string", minLength=6, maxLength=25)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Username available",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Can use username")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Username not available or validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function checkusername(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|min:6|max:25',
        ]);

        $user = User::where('username', $validatedData['username'])->first();

        if (!$user) {
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'message' => 'can use username : ' . $validatedData['username'],
            ]);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'code' => 422,
                'message' => 'can\'t use username : ' . $validatedData['username'],
            ], 422);
        }
    }

    protected function respondWithToken($token, $user)
    {
        $decodedToken = JWT::decode($token, new Key(env('JWT_SECRET'), env('JWT_ALGO')));
        $expirationTime = $decodedToken->exp;
        $expirationDate = date("Y-m-d H:i:s", $expirationTime);

        $user['avatar'] = env('IMAGE_URL') . '/' . $user['avatar'];

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'data' => $user,
            'token' => $token,
            'exp_timestamp' => $expirationTime,
            'exp' => $expirationDate,
        ], 200);
    }

    protected function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
