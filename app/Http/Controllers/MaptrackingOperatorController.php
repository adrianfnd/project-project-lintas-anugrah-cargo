<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\SuratJalanInfo;
use App\Models\Paket;
use Illuminate\Http\Request;

class MaptrackingOperatorController extends Controller
{
    public function index()
    {
        $suratjalans = SuratJalan::with(['driver'])
                        ->where('status', 'dikirim')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('operator.maptracking.index', compact('suratjalans'));
    }

    public function detail($id)
    {
        $suratJalan = SuratJalan::with(['driver'])
                        ->where('id', $id)
                        ->where('status', 'dikirim')
                        ->firstOrFail();

        $suratJalanInfos = SuratJalanInfo::where('surat_jalan_id', $id)
                        ->orderBy('checkpoint_time', 'desc')
                        ->get();

        $suratJalan->checkpoint_latitude = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $suratJalan->checkpoint_longitude = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        $paketIds = json_decode($suratJalan->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $suratJalan->list_paket = json_encode($list_paket);

        return view('operator.maptracking.show', compact('suratJalan', 'list_paket', 'list_paket_ids', 'suratJalanInfos'));
    }
}