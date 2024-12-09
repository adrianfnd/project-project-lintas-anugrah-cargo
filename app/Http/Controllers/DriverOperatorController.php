<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverOperatorController extends Controller
{
    public function index()
    {
       $drivers = Driver::paginate(10);

       return view('operator.driver.index', compact('drivers'));
    }

    public function detail($id)
    {
        $driver = Driver::findOrFail($id);

        $user = User::where('driver_id', $driver->id)->firstOrFail();

        return view('operator.driver.detail', compact('driver', 'user'));
    }
}
