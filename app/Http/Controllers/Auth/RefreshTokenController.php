<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class RefreshTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'token' => ['string', 'required'],
        ]);

        $key = env("JWT_SECRET_LOGIN");

        try {
            JWT::decode($request->token, new Key($key, 'HS256'));
            /**
             * jika token JWT valid, maka kode di dalam blok ini akan dijalankan
             */

             $user = User::where('remember_token', $request->token)->first();

             if (!$user) {
                 return response()->json([
                     'code' => 400,
                     'message' => "User not found"
                 ], 400);
             }
            
            /** 
             * Create token
             * 
             * @property user_id user id from db
             * @property iat issued at
             * @property exp expired token 1 hour
             */
            $payload = [
                'user_id' => $user->id,
                'iat' => time(),
                "exp" => time() + 3600,
            ];
    
            $jwt = JWT::encode($payload, $key, 'HS256');

            return response()->json([
                'code' => 200,
                'message' => 'ok',
                'data' => [
                    'token' => $jwt,
                ],
            ]);
        } catch (\Exception $e) {
            /**
             * jika terjadi error, maka kode di dalam blok ini akan dijalankan
             * misalnya token JWT tidak valid atau kunci rahasia tidak cocok
             */
            error_log($e);

            return response()->json([
                'code' => 400,
                'message' => 'Token invalid'
            ], 400);
        }
    }
}
