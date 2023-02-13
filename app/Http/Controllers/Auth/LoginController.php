<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class LoginController extends Controller
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
            'username' => ['alpha_num', 'required', 'min:3', 'max:25'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json([
                'message' => "User not found"
            ], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => "Password not match"
            ], 400);
        }

        $key = env("JWT_SECRET_LOGIN");

        // error_log($key);

        $payload = [
            'user_id' => $user->id,
            'iat' => time(),
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return response()->json([
            'token' => $jwt,
        ]);
    }
}
