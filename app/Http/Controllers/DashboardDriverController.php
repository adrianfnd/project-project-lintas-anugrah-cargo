<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardDriverController extends Controller
{
    public function index()
    {
        return view('driver.dashboard');
    }
}
