<?php

namespace App\Http\Controllers;

use App\Events\LoginRequestEvent;
use App\Http\Requests\LoginRequest;

class LoginRequestController extends Controller
{
    public function __invoke(LoginRequest $loginRequest)
    {
        event(new LoginRequestEvent(request()->input('email')));
        return response()->json(['message' => 'Please check your email for Magic Link'], 200);
    }
}
