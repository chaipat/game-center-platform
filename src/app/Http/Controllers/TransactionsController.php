<?php

namespace App\Http\Controllers;

use App\Models\TransactionsGame;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        $perPage = 20;
        $currentPage = request()->input('page', 1);

        $data = TransactionsGame::where('user_id', auth()->user()->id)->paginate($perPage, ['*'], 'page', $currentPage);

        $response = [
            'status' => 'OK',
            'code' => 200,
            'option' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_page' => $data->lastPage(),
            ],
            'lists' => $data->items(),
        ];
        return response()->json($response);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|numeric',
            'round_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'balance' => 'required|numeric',
            'bet' => 'required|numeric',
            'win' => 'required|numeric',
            'losses' => 'required|numeric',
            'profit' => 'required|numeric',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        try {
            $transactionGame = TransactionsGame::create($validatedData);
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $transactionGame,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
