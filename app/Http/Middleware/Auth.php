<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authorization = $request->header('Authorization');

        if (!$authorization) {
            return response()->json([
                'code' => 401,
                'message' => 'Required auth'
            ], 401);
        }

        $key = env("JWT_SECRET_LOGIN");
        $token = explode(' ', $authorization)[1];

        // error_log($token);

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            /**
             * jika token JWT valid, maka kode di dalam blok ini akan dijalankan
             */

             $exp = $decoded->exp;

             if ($exp < time()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Auth expired'
                ], 401);
             }

            $request->merge(["credential" => [
                "user_id" => $decoded->user_id
            ]]);

            return $next($request);
        } catch (\Exception $e) {
            /**
             * jika terjadi error, maka kode di dalam blok ini akan dijalankan
             * misalnya token JWT tidak valid atau kunci rahasia tidak cocok
             */
            error_log($e);

            return response()->json([
                'code' => 401,
                'message' => 'Auth invalid'
            ], 401);
        }
    }
}
