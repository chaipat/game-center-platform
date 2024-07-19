<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    public function create(Request $request)
    {
        // Add to transaction
        $validatedData = $request->validate([
            'type' => 'required|string|max:15',
            'amount' => 'required|numeric',
            'balance' => 'required|numeric',
            'status' => 'required|string|max:15',
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $transaction = Transactions::create($validatedData);

        if ($transaction) {
            // Update user balance
            $user = auth()->user();
            $user->balance = $user->balance + $validatedData['amount'];
            $user->save();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'transaction' => $transaction,
                    'user' => $user,
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Create failed'
            ], 500);
        }
    }
}
