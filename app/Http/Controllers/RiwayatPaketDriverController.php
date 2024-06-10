<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPaket;

class RiwayatPaketDriverController extends Controller
{
    public function index()
    {
        // $riwayatpakets = RiwayatPaket::where('driver_id', auth()->user()->driver->id)->paginate(10);

        // return view('driver.riwayatpaket.index', compact('riwayatpakets'));
        return view('driver.riwayatpaket.index');

    }

    public function detail()
    {
        // $riwayatpaket = RiwayatPaket::with(['driver', 'paket', 'suratJalan'])->findOrFail($id);
        
        // return view('driver.riwayatpaket.detail', compact('riwayatpaket'));
        return view('driver.riwayatpaket.detail');
    }
}