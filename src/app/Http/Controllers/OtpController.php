<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function request(Request $request)
    {
        $validatedData = $request->validate([
            'channel' => 'required|string|max:15',
            'contact' => 'required|string|max:15',
            'expired_at' => 'required|numeric',
            'length_otp' => 'required|numeric',
            'length_ref_code' => 'required|numeric',
            'verify_count' => 'required|numeric',
            'code' => 'required|string|max:10',
            'ref_code' => 'required|string|max:10',
        ]);

        $validatedData['status'] = 'pending';
        $validatedData['expired_at'] = Carbon::parse($validatedData['expired_at'])->toDateTimeString();
        $otp = Otp::create($validatedData);
        $data = $otp->only(['id', 'ref_code']);

        if ($otp) {
            return response()->json([
                'status' => 'OK',
                'code' => 200,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'code' => 500,
                'message' => 'Create failed'
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:10',
            'contact' => 'required|string|max:15',
            'ref_code' => 'required|string|max:10',
        ]);

        $otp = Otp::where([
            'contact' => $validatedData['contact'],
            'code' => $validatedData['code'],
            'status' => 'pending',
        ])->first();

        if ($otp) {
            // Check ref_code
            if ($otp->ref_code == $validatedData['ref_code']) {
                // Check expired
                $exp = Carbon::parse($otp->expired_at);
                if ($exp->gt(Carbon::now())) {
                    // Valid OTP
                    $otp->status = 'verified';
                    $otp->save();
                    $data = $otp->only(['id', 'status', 'contact', 'ref_code']);
                    return response()->json([
                        'status' => 'OK',
                        'code' => 200,
                        'data' => $data,
                    ], 200);
                } else {
                    // Expired
                    return response()->json([
                        'status' => 'failed',
                        'code' => 500,
                        'message' => 'Code expired'
                    ], 500);
                }
            } else {
                // Check verify time
                if ($otp->verify_time >= $otp->verify_count) {
                    return response()->json([
                        'status' => 'failed',
                        'code' => 500,
                        'message' => 'Verify exceeded the limit times'
                    ], 500);
                }
                // Invalid verify code
                $otp->verify_time = $otp->verify_time + 1;
                $otp->save();
                return response()->json([
                    'status' => 'failed',
                    'code' => 500,
                    'message' => 'Invalid verify code'
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'code' => 500,
                'message' => 'Invalid code'
            ], 404);
        }
    }
}
