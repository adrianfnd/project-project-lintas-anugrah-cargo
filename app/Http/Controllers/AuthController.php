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
            'username' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user()->load('role');

            if ($user->role->name == 'admin') {
                return redirect()->route('admin.operator.index');
            } elseif ($user->role->name == 'operator') {
                return redirect()->route('operator.dashboard');
            } elseif ($user->role->name == 'driver') {
                return redirect()->route('driver.dashboard');
            }
        }
    
        return back()->withErrors(['credentials' => 'Password atau Username yang anda masukkan salah']);
    }    
}
