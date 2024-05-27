<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = $user->role()->first()->name;

            switch ($role) {
                case 'Admin':
                    return redirect()->route('admin.dashboard');
                    break;
                case 'Operator':
                    return redirect()->route('operator.dashboard');
                    break;
                case 'Driver':
                    return redirect()->route('driver.dashboard');
                    break;
                default:
                    return back()->withErrors(['credentials' => 'Telah terjadi kesalahan, silahkan login pakai akun yang lain.']);
                    break;
            }
        }
        return back()->withErrors(['credentials' => 'Password atau Email yang anda masukkan salah']);
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
                    ? back()->with('status', __($response))
                    : back()->withErrors(['email' => __($response)]);
    }
}
