<?php

namespace App\Http\Controllers;

use App\MagicCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginAuthenticateController extends Controller
{
    public function __invoke(Request $request)
    {
        if(!request()->filled('token') && !request()->filled('code')) {
            return response()->json(['error' => 'Something went wrong', 400]);
        }

        $valid = MagicCredentials::query()
            ->get()
            ->filter(function($magic) {
                if(request()->filled('token')) {
                    return Hash::check(request()->input('token'), $magic->token);
                }
                return Hash::check(request()->input('code'), $magic->code);
            })
            ->first();

        if(!$valid) {
            return response()->json(['message' => 'The Token is not valid or it has been expired'], 422);
        }

        Auth::loginUsingId($valid->user_id);

    }
}
