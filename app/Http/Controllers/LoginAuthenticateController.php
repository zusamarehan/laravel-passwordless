<?php

namespace App\Http\Controllers;

class LoginAuthenticateController extends Controller
{
    public function __invoke()
    {
        return redirect()->to('home');
    }
}
