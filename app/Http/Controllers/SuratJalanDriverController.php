<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\SuratJalanInfo;
use App\Models\Paket;
use App\Models\RiwayatPaket;
use Illuminate\Support\Str;

class SuratJalanDriverController extends Controller
{
    public function index()
    {
        $suratjalans = SuratJalan::where('driver_id', auth()->user()->driver->id)
                        ->where('status', 'proses')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('driver.suratjalan.index', compact('suratjalans'));
    }

    public function detail($id)
    {
        $suratjalan = SuratJalan::with(['driver'])
                        ->where('id', $id)
                        ->where('status', 'proses')
                        ->firstOrFail();

        $paketIds = json_decode($suratjalan->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $suratjalan->list_paket = json_encode($list_paket);

        return view('driver.suratjalan.detail', compact('suratjalan', 'list_paket', 'list_paket_ids'));
    }

    public function startDelivery($id)
    {
        $suratJalan = SuratJalan::where('id', $id)
                        ->where('status', 'proses')
                        ->firstOrFail();
        $suratJalan->status = 'dikirim';
        $suratJalan->start_delivery_time = now();
        $suratJalan->save();

        $paketIds = json_decode($suratJalan->list_paket, true);
        Paket::whereIn('id', $paketIds)->update(['status' => 'dikirim']);

        $driver = auth()->user()->driver;
        $driver->status = 'dalam perjalanan';
        $driver->save();

        // Informasi Tracking surat jalan
        SuratJalanInfo::create([
            'surat_jalan_id' => $suratJalan->id,
            'information' => 'Pengiriman dimulai',
            'latitude' => $suratJalan->sender_latitude,
            'longitude' => $suratJalan->sender_longitude,
            'checkpoint_time' => now(),
        ]);

        return redirect()->route('driver.maptracking.show', $suratJalan->id);
    }
}
