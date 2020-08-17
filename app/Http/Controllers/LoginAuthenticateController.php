<?php

namespace App\Http\Controllers;

use App\Support\Passwordless;
use Illuminate\Support\Facades\Auth;

class LoginAuthenticateController extends Controller
{
    public function __invoke()
    {
        if(!request()->hasValidSignature()) {
            return response()->json(['error' => 'The link has expired'], 400);
        }

        if(!request()->filled('token') && !request()->filled('code')) {
            return response()->json(['error' => 'Something went wrong'], 400);
        }

        $verified = Passwordless::verify();

        if(!$verified) {
            return response()->json(['message' => 'The Token is not valid or it has been expired'], 422);
        }

        Auth::loginUsingId($verified->user_id);
        return "Logged In";
    }
}
