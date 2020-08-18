<?php

namespace App\Http\Controllers;

use App\Events\LoggedInEvent;
use App\Support\Passwordless;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Cookie;

class LoginAuthenticateController extends Controller
{
    public function __invoke()
    {
        if(request()->filled('token')) {
            if(!request()->hasValidSignature()) {
                return response()->json(['error' => 'The link has expired'], 400);
            }
        }

        if(!request()->filled('token') && !request()->filled('code')) {
            return response()->json(['error' => 'Something went wrong'], 400);
        }

        $verified = Passwordless::verify();

        if(!$verified) {
            return response()->json(['message' => 'The Token is not valid or it has been expired'], 422);
        }

        $cookie = base64_encode($verified->token.uniqid().$verified->code);
        event(new LoggedInEvent($verified->user_id, $cookie));

        return response('ok')
            ->cookie(new Cookie('pudding_v2Cookie', $cookie, now()->addDays(30)));

    }
}
