<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('client.auth.login');
    }
}

