<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\SuratJalan;

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
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
    
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user()->load('role');
    
            if ($user->role->name == 'admin') {
                return redirect()->route('admin.operator.index');
            } elseif ($user->role->name == 'manager_operasional') {
                return redirect()->route('manager-operasional.dashboard'); 
            } elseif ($user->role->name == 'operator') {
                return redirect()->route('operator.dashboard');
            } elseif ($user->role->name == 'driver') {
                $driver = $user->driver;
    
                if ($driver->status == 'dalam perjalanan') {
                    $suratJalan = SuratJalan::where('status', 'dikirim')
                        ->where('driver_id', $driver->id)
                        ->latest()
                        ->first();
    
                    if ($suratJalan) {
                        return redirect()->route('driver.maptracking.show', ['id' => $suratJalan->id]);
                    } else {
                        return redirect()->route('driver.suratjalan.index');
                    }
                } else {
                    return redirect()->route('driver.suratjalan.index');
                }
            }
        }
    
        return back()->withErrors(['credentials' => 'Password atau Username yang anda masukkan salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
