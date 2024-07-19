<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransactionsBet;
use Faker\Factory;
use Illuminate\Http\Request;

class CreateMocDataController extends Controller
{
    public function transactionbet(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|numeric',
            'num_rec' => 'required|numeric',
        ]);

        try {
            $faker = Factory::create();

            $numberOfRecords = $validatedData['num_rec'];

            for ($i = 0; $i < $numberOfRecords; $i++) {
                TransactionsBet::create([
                    'user_id' => $validatedData['user_id'],
                    'game_id' => $faker->numberBetween(1, 2),
                    'round_id' => $faker->numberBetween(1000, 9000),
                    'hand' => $faker->numberBetween(1, 10),
                    'bet' => $faker->randomFloat(2, 10, 1000),
                    'multi' => $faker->randomFloat(2, 1, 10),
                    'profit' => $faker->randomFloat(2, -10000, 10000),
                ]);
            }

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'message' => 'Insert complet',
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
