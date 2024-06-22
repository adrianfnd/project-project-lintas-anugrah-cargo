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
        $riwayatpakets = RiwayatPaket::with(['driver', 'suratJalan'])->paginate(10);
        
        return view('operator.riwayatpaket.index', compact('riwayatpakets'));
    }

    public function detail($id)
    {
        $riwayatpaket = RiwayatPaket::with(['driver', 'suratJalan'])->findOrFail($id);
        
        $paketIds = json_decode($riwayatpaket->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $riwayatpaket->list_paket = json_encode($list_paket);

        return view('operator.riwayatpaket.detail', compact('riwayatpaket', 'list_paket', 'list_paket_ids'));
    }
}
