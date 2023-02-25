<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UpdateProfileController extends Controller
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
            'name' => ['string'],
            'username' => ['alpha_num', 'min:3', 'max:25'],
        ]);

        $user = User::find($request->credential["user_id"]);

        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->username) {
            if ($request->username !== $user->username) {
                $userCheck = User::where('username', $request->username)->first();

                if ($userCheck) {
                    return response()->json([
                        'code' => 400,
                        'message' => "Username already exist"
                    ], 400);
                }
            }

            $user->username = $request->username;
        }
 
        $user->save();

        return response()->json([
            'code' => 200,
            'message' => 'ok',
            'data' => $user,
        ]);
    }
}
