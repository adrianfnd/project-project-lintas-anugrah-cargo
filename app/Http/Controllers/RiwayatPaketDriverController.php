<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPaket;
use App\Models\Driver;
use App\Models\Paket;
use App\Models\SuratJalan;
use App\Models\SuratJalanInfo;
use Illuminate\Http\Request;

class RiwayatPaketDriverController extends Controller
{
    public function index()
    {
        $riwayatpakets = RiwayatPaket::with(['driver', 'suratJalan'])
                    ->where('driver_id', auth()->user()->driver_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('driver.riwayatpaket.index', compact('riwayatpakets'));
    }

    public function detail($id)
    {
        $riwayatpaket = RiwayatPaket::with(['driver', 'suratJalan'])
                    ->where('driver_id', auth()->user()->driver_id)
                    ->where('id', $id)
                    ->firstOrFail();

        $riwayatpaket->suratJalan->checkpoint_latitude = json_decode($riwayatpaket->suratJalan->checkpoint_latitude, true) ?? [];
        $riwayatpaket->suratJalan->checkpoint_longitude = json_decode($riwayatpaket->suratJalan->checkpoint_longitude, true) ?? [];

        $suratJalanInfos = SuratJalanInfo::where('surat_jalan_id', $riwayatpaket->suratJalan->id)
                    ->orderBy('checkpoint_time', 'desc')
                    ->get();

        $paketIds = json_decode($riwayatpaket->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $riwayatpaket->list_paket = json_encode($list_paket);

        return view('driver.riwayatpaket.detail', compact('riwayatpaket', 'list_paket', 'list_paket_ids', 'suratJalanInfos'));
    }
}
