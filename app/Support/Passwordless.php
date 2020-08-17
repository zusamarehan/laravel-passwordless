<?php

namespace App\Support;

use App\MagicCredentials;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Passwordless
{
    public $email;
    public $user;
    public $token;
    public $code;
    public $url;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function getUser()
    {
        return $this->user = User::query()
            ->findUserByEmail($this->email)
            ->first();
    }

    public function generateToken()
    {
        return $this->token = Str::random(25).uniqid().Str::random(26);
    }

    public function generateCode()
    {
        return $this->code = mt_rand(1000,9999).'-'.mt_rand(1000,9999);
    }

    public function generateURL()
    {
        return $this->url = URL::temporarySignedRoute('login.authenticate.email', now()->addMinutes(1), [
            'token' => $this->token
        ]);
    }

    public static function verify()
    {
        return MagicCredentials::query()
            ->get()
            ->filter(function($magic) {
                if(request()->filled('token')) {
                    return Hash::check(request()->input('token'), $magic->token);
                }
                return Hash::check(request()->input('code'), $magic->code);
            })
            ->first();
    }
}
