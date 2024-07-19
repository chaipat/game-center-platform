<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/activity-logs",
     *     summary="Create activity log",
     *     tags={"Activity Logs"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="game_id", type="integer"),
     *             @OA\Property(property="activity", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Activity log created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
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
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'numeric',
            'activity' => 'required|string',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        try {
            $log = ActivityLog::create($validatedData);
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $log,
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
