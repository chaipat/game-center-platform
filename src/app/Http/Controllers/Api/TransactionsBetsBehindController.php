<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionsBet;
use Illuminate\Http\Request;

class TransactionsBetsBehindController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/transaction/betbehind",
     *     summary="Create transaction behind",
     *     tags={"Transactions Bet Behind"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="round_id", type="integer"),
     *             @OA\Property(property="bet", type="number", format="float"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction bet created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="balance", type="number", format="float"),
     *                 @OA\Property(property="total_bet", type="number", format="float")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or not enough money",
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
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'round_id' => 'required|numeric',
            'bet' => 'required|numeric',
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['game_id'] = 1;

        try {
            $user = auth()->user();
            if ($user->balance > $validatedData['bet']) {
                // Update balance user
                $user->balance = $user->balance - $validatedData['bet'];
                $user->save();

                // Create transaction
                $transactionGame = TransactionsBet::create($validatedData);

                $data = [
                    'id' => $transactionGame->id,
                    'balance' => $user->balance,
                    'total_bet' => $transactionGame->bet,
                ];

                return response()->json([
                    'status' => 'OK',
                    'code' => 200,
                    'data' => $data,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'ERROR',
                    'code' => 422,
                    'message' => 'not enough money',
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
