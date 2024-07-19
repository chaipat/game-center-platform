<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\UserLog;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/topup",
     *     tags={"Topup"},
     *     summary="Create a new topup transaction",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="amount", type="number", example="200"),
     *                 @OA\Property(property="card_name", type="string", example="Test Card"),
     *                 @OA\Property(property="card_number", type="string", example="123456789"),
     *                 @OA\Property(property="expiration_date", type="string", example="08/24"),
     *                 @OA\Property(property="cvc", type="string", example="1234"),
     *                 @OA\Property(property="type", type="string", example="TOPUP", enum={"TOPUP","WITHDRAW","BONUS","REFER_FRIEND"}),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", type="object", description="User object"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error occurred",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="Internal Server Error"),
     *         ),
     *     ),
     * )
     */

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'card_name' => 'required|string',
            'card_number' => 'required|string',
            'expiration_date' => 'required|string',
            'cvc' => 'required|string',
            'type' => 'required|string|in:TOPUP,WITHDRAW,BONUS,REFER_FRIEND',
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['status'] = 'Successs';
        $validatedData['note'] = $validatedData['card_name'] . ' ' . $validatedData['card_number'] . ' ' . $validatedData['expiration_date'] . ' ' . $validatedData['cvc'];

        try {
            $transaction = Transactions::create($validatedData);

            // Update user balance
            $user = auth()->user();
            $user->balance = $user->balance + $validatedData['amount'];
            $user->save();

            UserLog::createLog($user->id, 'Topup');

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => [
                    'transaction' => $transaction,
                    'user' => $user,
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
}
