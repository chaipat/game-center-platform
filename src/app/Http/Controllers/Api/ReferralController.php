<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class ReferralController extends Controller
{

    public function index()
    {
        try {
            $perPage = request()->get('per_page', 10);
            $data = User::where('ref_id', auth()->user()->id)->paginate($perPage);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
