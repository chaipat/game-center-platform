<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionsCashout;
use Illuminate\Http\Request;

class TransactionCashoutController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'round_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'cashout' => 'required|numeric',
        ]);

        try {
            $data = TransactionsCashout::create($validatedData);

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
