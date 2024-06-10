<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPaket;
use App\Models\Driver;
use App\Models\Paket;
use App\Models\SuratJalan;

class RiwayatPaketOperatorController extends Controller
{
    public function index()
    {
    //     $riwayatpakets = RiwayatPaket::with(['driver', 'paket', 'suratJalan'])->paginate(10);
        
    //     return view('operator.riwayatpaket.index', compact('riwayatpakets'));
    return view('operator.riwayatpaket.index');
}

    public function detail()
    {
        // $riwayatpaket = RiwayatPaket::with(['driver', 'paket', 'suratJalan'])->findOrFail($id);
        
        // return view('operator.riwayatpaket.detail', compact('riwayatpaket'));
        return view('operator.riwayatpaket.detail');
    }
}
