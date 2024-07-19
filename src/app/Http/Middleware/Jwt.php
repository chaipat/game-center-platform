<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException as ExceptionsJWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class Jwt
{

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = FacadesJWTAuth::parseToken()->authenticate();
        } catch (ExceptionsJWTException $e) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return $next($request);
    }
}
