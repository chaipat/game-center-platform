<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionsBet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsBetsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/transaction/bet",
     *     summary="Get transaction Bet",
     *     tags={"Transactions Bet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of transactions per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Start date for filtering transactions",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="End date for filtering transactions",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="game_id",
     *         in="query",
     *         description="ID of the game for filtering transactions",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="round_id",
     *         in="query",
     *         description="ID of the round for filtering transactions",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID of the user for filtering transactions",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        try {
            $perPage = request()->get('per_page', 10);
            $startDate = request()->get('startDate');
            $endDate = request()->get('endDate');
            $gameId = request()->get('game_id');
            $roundId = request()->get('round_id');
            $userId = request()->get('user_id');

            $query = TransactionsBet::query();

            $query->with(['user:id,name,avatar,balance']);

            if ($userId !== null) {
                $query->where('user_id', $userId);
            }

            if ($gameId !== null) {
                $query->where('game_id', $gameId);
            }

            if ($roundId !== null) {
                $query->where('round_id', $roundId);
            }

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $data = $query->paginate($perPage);

            if ($data->total() > 0) {
                $data[0]['user']['avatar'] = env('IMAGE_URL') . '/' . $data[0]['user']['avatar'];
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/transaction/bet",
     *     summary="Create a new transaction",
     *     tags={"Transactions Bet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"round_id", "game_id", "bet"},
     *             @OA\Property(property="round_id", type="integer"),
     *             @OA\Property(property="game_id", type="integer"),
     *             @OA\Property(property="hand", type="integer", example="1"),
     *             @OA\Property(property="bet", type="number", format="float", example="10.5"),
     *             @OA\Property(property="multi", type="string"),
     *             @OA\Property(property="profit", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=123),
     *                 @OA\Property(property="balance", type="number", format="float", example="100.5"),
     *                 @OA\Property(property="total_bet", type="number", format="float", example="10.5")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or not enough money",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string", example="not enough money")
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
            'game_id' => 'required|numeric',
            'hand' => 'numeric',
            'bet' => 'required|numeric',
            'multi' => 'string',
            'profit' => 'numeric',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

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

    /**
     * @OA\Post(
     *     path="/api/transaction/blackjack/bet",
     *     summary="Create a new blackjack transaction bet",
     *     tags={"Transactions Bet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="table_id", type="string", example="blackjack_table_1"),
     *                 @OA\Property(property="bet_id", type="string", example="1234"),
     *                 @OA\Property(property="bet", type="number", format="float", example=10.50),
     *                 @OA\Property(property="bet_type", type="string", example="BET_BEHIND_SPLIT", enum={"NORMAL", "SPLIT", "PERFECT_PAIR", "PLUSTHREE", "DOUBLE_DOWN", "INSURANCE", "BET_BEHIND", "BET_BEHIND_SPLIT", "BET_BEHIND_INSURANCE", "BET_BEHIND_DOUBLE", "BET_BEHIND_DOUBLE_SPLIT"}),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="code", type="integer", example=400),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="Internal server error"),
     *         ),
     *     )
     * )
     */
    public function createBlackjack(Request $request)
    {
        $validatedData = $request->validate([
            'table_id' => 'required|string',
            'bet_id' => 'required|string',
            'bet' => 'required|numeric',
            'bet_type' => 'required|string|in:NORMAL,SPLIT,PERFECT_PAIR,PLUSTHREE,DOUBLE_DOWN,INSURANCE,BET_BEHIND,BET_BEHIND_SPLIT,BET_BEHIND_INSURANCE,BET_BEHIND_DOUBLE,BET_BEHIND_DOUBLE_SPLIT',
        ]);

        try {
            $validatedData['game_id'] = '1';
            $validatedData['user_id'] = Auth::id();

            $data = TransactionsBet::create($validatedData);

            // Update balance
            $user = User::find(Auth::id());
            $user->balance = $user->balance - $validatedData['bet'];
            $user->save();

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/transaction/bet/{id}",
     *     summary="Update an existing transaction",
     *     tags={"Transactions Bet"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the transaction to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"round_id", "game_id", "bet"},
     *             @OA\Property(property="round_id", type="integer"),
     *             @OA\Property(property="game_id", type="integer"),
     *             @OA\Property(property="hand", type="integer"),
     *             @OA\Property(property="bet", type="number", format="float", example="10.5"),
     *             @OA\Property(property="multi", type="string"),
     *             @OA\Property(property="profit", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=123),
     *                 @OA\Property(property="balance", type="number", format="float", example="100.5"),
     *                 @OA\Property(property="total_bet", type="number", format="float", example="10.5")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or not enough money",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string", example="not enough money")
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
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'round_id' => 'required|numeric',
            'game_id' => 'required|numeric',
            'hand' => 'numeric',
            'bet' => 'required|numeric',
            'multi' => 'string',
            'profit' => 'numeric',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        try {
            $user = auth()->user();
            if ($user->balance > $validatedData['bet']) {
                // Update transaction
                $transactionGame = TransactionsBet::findOrFail($id);
                $oldbet = $transactionGame->bet;
                $transactionGame->fill($validatedData);
                $transactionGame->save();

                // Update balance user
                $user->balance = $user->balance + $oldbet;
                $user->balance = $user->balance - $validatedData['bet'];
                $user->save();

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
