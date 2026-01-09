<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* ================== VIEW ================== */

    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('client.auth.login');
    }



    /* ================== ACTION ================== */

    // Đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:tb_customer,email',
            'phone'    => 'required|unique:tb_customer,phone',
            'password' => 'required|min:6',
        ]);

        Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // 👉 Sau đăng ký quay về login cho đúng UX
        return redirect()
            ->route('client.login')
            ->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
    }

    // Đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng');
    }

    // Đăng xuất
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home');
    }
}
