<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }


    public function callback()
    {
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();

        $customer = Customer::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'       => $googleUser->getName(),
                'google_id'  => $googleUser->getId(),
                'password'   => bcrypt(uniqid()),
            ]
        );

        Auth::guard('customer')->login($customer);

        return redirect('/')->with('success', 'Đăng nhập Google thành công!');
    }

}

