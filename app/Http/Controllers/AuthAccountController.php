<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthAccountController extends Controller
{
    public function redirect(Request $request)
    {
        return Socialite::driver($request->provider_name)->redirect();
    }
    public function callback()
    {
        return "HI";
    }
}
