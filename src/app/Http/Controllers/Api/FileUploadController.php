<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/upload",
     *     summary="Upload user avatar",
     *     tags={"Upload"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"file"},
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avatar uploaded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="data", type="string", example="https://example.com/avatar/image.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="File not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function upload(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|file|image|mimes:png,jpg,jpeg|max:2048',
        // ]);s

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('avatar');

            // Update filename in database
            $user = auth()->user();
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $user->avatar = $path;
            $user->save();

            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => env('IMAGE_URL') . '/' . $path,
            ], 200);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'code' => 422,
                'message' => 'file not found',
            ], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/get-link",
     *     summary="Get user avatar link",
     *     tags={"Upload"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Avatar link retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="data", type="string", example="https://example.com/avatar/image.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="User not authenticated or avatar link not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ERROR"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function getLink()
    {
        $user = auth()->user();
        if ($user) {
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $user->avatar,
            ], 200);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'code' => 422,
                'message' => 'file not found',
            ], 422);
        }
    }

    public function getFile()
    {
        $user = auth()->user();
        if ($user) {
            $file = Storage::disk()->get($user->avatar);
            $mimeType = Storage::mimeType($file);
            return response($file)->header('Content-Type', $mimeType);
            // return $file;
        } else {
            return response()->json([
                'status' => 'ERROR',
                'code' => 422,
                'message' => 'file not found',
            ], 422);
        }
    }
}
