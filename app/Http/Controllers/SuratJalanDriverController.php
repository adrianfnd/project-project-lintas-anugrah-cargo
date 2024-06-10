<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;

class SuratJalanDriverController extends Controller
{
    public function index()
    {
        // $suratJalans = SuratJalan::where('driver_id', auth()->user()->driver->id)->paginate(10);

        // return view('driver.suratjalan.index', compact('suratJalans'));
        return view('driver.suratjalan.index');
    }

    public function detail()
    {
        // $suratJalan = SuratJalan::with(['paket', 'driver'])->findOrFail($id);

        // return view('driver.suratjalan.detail', compact('suratJalan'));
        return view('driver.suratjalan.detail');
    }

    // public function antarPaket($id)
    // {
    //     $suratJalan = SuratJalan::findOrFail($id);

    //     $suratJalan->status = 'delivered';

    //     $suratJalan->save();

    //     $riwayatPaket = new RiwayatPaket();
    //     $riwayatPaket->driver_id = auth()->user()->driver->id;
    //     $riwayatPaket->paket_id = $suratJalan->paket_id;
    //     $riwayatPaket->surat_jalan_id = $suratJalan->id;
    //     $riwayatPaket->status = 'delivered';
    //     $riwayatPaket->save();

    //     return redirect()->route('driver.suratjalan.detail', $id)->with('success', 'Paket berhasil diantar.');
    // }
}
