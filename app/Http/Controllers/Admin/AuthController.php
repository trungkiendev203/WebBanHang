<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // ✅ thêm dòng này

class AuthController extends Controller
{
    public function showLogin() {
        return view('admin.login');
    }

    public function login(Request $r)
    {
        $r->validate([
            'account_user' => 'required',
            'pass_user' => 'required',
        ]);

        // ✅ Dùng model thay DB::table
        $user = User::where('account_user', $r->account_user)
                    ->where('pass_user', $r->pass_user)
                    ->where('type_user', 0)
                    ->first();

        if ($user) {
            session(['admin_login' => $user]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Sai tài khoản hoặc mật khẩu!');
    }

    public function logout()
    {
        session()->forget('admin_login');
        return redirect()->route('admin.login');
    }
}

