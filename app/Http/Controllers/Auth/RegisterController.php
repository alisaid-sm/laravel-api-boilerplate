<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // error_log(json_encode($request->credential));

        $request->validate([
            'name' => ['string', 'required'],
            'username' => ['alpha_num', 'required', 'min:3', 'max:25', 'unique:users,username'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ]);

        $key = env("JWT_SECRET_LOGIN");

        $payload = [
            'iat' => time(),
        ];

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => JWT::encode($payload, $key, 'HS256'),
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'ok',
        ]);
    }
}
