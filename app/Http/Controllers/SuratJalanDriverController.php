<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Paket;
use App\Models\RiwayatPaket;
use Illuminate\Support\Str;

class SuratJalanDriverController extends Controller
{
    public function index()
    {
        $suratjalans = SuratJalan::where('driver_id', auth()->user()->driver->id)->paginate(10);

        return view('driver.suratjalan.index', compact('suratjalans'));
    }

    public function detail($id)
    {
        $suratjalan = SuratJalan::with(['driver'])->findOrFail($id);

        $paketIds = json_decode($suratjalan->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $suratjalan->list_paket = json_encode($list_paket);

        return view('driver.suratjalan.detail', compact('suratjalan', 'list_paket', 'list_paket_ids'));
    }

    public function antarPaket($id)
    {
        $suratJalan = SuratJalan::findOrFail($id);

        $suratJalan->status = 'delivered';

        $suratJalan->save();

        $riwayatPaket = new RiwayatPaket();
        $riwayatPaket->driver_id = auth()->user()->driver->id;
        $riwayatPaket->paket_id = $suratJalan->paket_id;
        $riwayatPaket->surat_jalan_id = $suratJalan->id;
        $riwayatPaket->status = 'delivered';
        $riwayatPaket->save();

        return redirect()->route('driver.suratjalan.detail', $id)->with('success', 'Paket berhasil diantar.');
    }
}
