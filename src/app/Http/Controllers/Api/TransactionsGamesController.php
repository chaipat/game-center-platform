<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionsBet;
use App\Models\TransactionsGame;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsGamesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/transaction",
     *     summary="Get transactions",
     *     tags={"Transactions"},
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
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
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
    public function index()
    {
        try {
            $perPage = request()->get('per_page', 10);
            $startDate = request()->get('startDate');
            $endDate = request()->get('endDate');

            $query = TransactionsGame::select([
                'transactions_games.id',
                'game_news.name as game',
                'transactions_games.round_id',
                'transactions_games.amount',
                'transactions_games.balance',
                'transactions_games.created_at',
                'transactions_games.updated_at',
                'transactions_games.created_by',
                'transactions_games.updated_by',
            ])
                ->leftJoin('game_news', 'transactions_games.game_id', '=', 'game_news.id')
                ->where('transactions_games.user_id', auth()->user()->id);

            if ($startDate && $endDate) {
                $query->whereBetween('transactions_games.created_at', [$startDate, $endDate]);
            }

            $data = $query->paginate($perPage);

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
     *     path="/api/transaction",
     *     summary="Create transaction",
     *     tags={"Transactions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"game_id", "data"},
     *             @OA\Property(property="game_id", type="integer"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     required={"round_id", "user_id", "amount"},
     *                     @OA\Property(property="round_id", type="integer"),
     *                     @OA\Property(property="user_id", type="integer"),
     *                     @OA\Property(property="amount", type="number", format="float")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transactions created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="create_count", type="integer", example=3),
     *             @OA\Property(property="error_count", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="code", type="integer", example=500),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'numeric',
            'data' => 'required|array',
        ]);

        try {
            if ($request->has('data') && is_array($request->data)) {
                $errorCount = 0;
                foreach ($request->data as $item) {
                    if (isset($item['round_id']) && isset($item['user_id']) && isset($item['amount'])) {
                        $data['game_id'] = $validatedData['game_id'];
                        $data['round_id'] = $item['round_id'];
                        $data['user_id'] = $item['user_id'];
                        $data['amount'] = $item['amount'];

                        // Update user balance
                        $user = User::find($item['user_id']);
                        if ($user) {
                            if ($data['amount'] >= 0) {
                                // Update balance user
                                $user->balance = $user->balance + $data['amount'];
                                $user->save();

                                $data['win'] = $data['amount'];
                            }

                            if ($data['amount'] < 0) {
                                // Update balance user
                                $user->balance = $user->balance + $data['amount'];
                                $user->save();

                                $data['losses'] = abs($data['amount']);
                            }

                            $data['bet'] = $item['amount'];

                            $saveData[] = TransactionsGame::create($data);
                        } else {
                            $errorCount++;
                        }
                    } else {
                        $errorCount++;
                    }
                }
                return response()->json([
                    'status' => 'OK',
                    'code' => 200,
                    'create_count' => count($saveData),
                    'error_count' => $errorCount,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'code' => 500,
                    'message' => 'no data',
                ], 500);
            }
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
     *     path="/api/transaction/blackjack",
     *     tags={"Transactions"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="table_id", type="string", example="blackjack_table_1"),
     *                 @OA\Property(property="game_status", type="integer", example="1"),
     *                 @OA\Property(property="total_income", type="number", format="float", example="100.50"),
     *                 @OA\Property(property="total_loss", type="number", format="float", example="20.25"),
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
            'game_status' => 'required|numeric',
            'total_income' => 'required|numeric',
            'total_loss' => 'required|numeric',
        ]);

        try {
            $validatedData['game_id'] = '1';
            $validatedData['user_id'] = Auth::id();

            $data = TransactionsGame::create($validatedData);

            // Update balance
            $user = User::find(Auth::id());
            if ($validatedData['total_income'] > 0) $user->balance = $user->balance + $validatedData['total_income'];
            if ($validatedData['total_loss'] > 0) $user->balance = $user->balance - $validatedData['total_loss'];
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
     *     path="/api/transaction/{id}",
     *     summary="Update an existing transaction",
     *     tags={"Transactions"},
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
     *             required={"game_id", "round_id", "user_id", "amount"},
     *             @OA\Property(property="game_id", type="integer"),
     *             @OA\Property(property="round_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="amount", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|numeric',
            'round_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $transactionGame = TransactionsBet::findOrFail($id);
        $transactionGame->fill($validatedData);
        $transactionGame->save();
    }
}
