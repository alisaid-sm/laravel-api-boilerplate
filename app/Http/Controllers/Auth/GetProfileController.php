<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class GetProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = User::where('id', $request->credential["user_id"])->first();

        if (!$user) {
            return response()->json([
                'code' => 400,
                'message' => "User not found",
            ], 400); 
        }

        return response()->json([
            'code' => 200,
            'message' => 'ok',
            'data' => $user,
        ]);
    }
}
