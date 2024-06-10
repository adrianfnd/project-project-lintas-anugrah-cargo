<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Driver;
use App\Models\Paket;

class SuratJalanOperatorController extends Controller
{
    public function index()
    {
        // $suratjalans = SuratJalan::with(['driver', 'paket'])->paginate(10);

        // return view('operator.suratjalan.index', compact('suratjalans'));
        return view('operator.suratjalan.index');

    }

    public function create()
    {
        // $drivers = Driver::all();
        
        // $pakets = Paket::all();

        // return view('operator.suratjalan.create', compact('drivers', 'pakets'));
        return view('operator.suratjalan.create');
    }

    public function detail()
    {
        // $suratjalan = SuratJalan::with(['driver', 'paket'])->findOrFail($id);

        // return view('operator.suratjalan.detail', compact('suratjalan'));
        return view('operator.suratjalan.detail');

    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'driver_id' => 'required|exists:drivers,id',
    //         'paket_id' => 'required|exists:pakets,id',
    //         'status' => 'required|string|max:255'
    //     ]);

    //     $paket = Paket::findOrFail($request->paket_id);

    //     $suratjalan = new SuratJalan();
    //     $suratjalan->driver_id = $request->driver_id;
    //     $suratjalan->paket_id = $request->paket_id;
    //     $suratjalan->status = $request->status;
    //     $suratjalan->latitude = $paket->sender_latitude;
    //     $suratjalan->longitude = $paket->sender_longitude;
    //     $suratjalan->save();

    //     return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil ditambahkan.');
    // }

    public function edit()
    {
        // $suratjalan = SuratJalan::findOrFail($id);
        // $drivers = Driver::all();
        // $pakets = Paket::all();

        // return view('operator.suratjalan.edit', compact('suratjalan', 'drivers', 'pakets'));
        return view('operator.suratjalan.edit');
    }

    // public function update(Request $request, $id)
    // {
    //     $suratjalan = SuratJalan::findOrFail($id);

    //     $request->validate([
    //         'driver_id' => 'required|exists:drivers,id',
    //         'paket_id' => 'required|exists:pakets,id',
    //         'status' => 'required|string|max:255'
    //     ]);

    //     $paket = Paket::findOrFail($request->paket_id);

    //     $suratjalan->driver_id = $request->driver_id;
    //     $suratjalan->paket_id = $request->paket_id;
    //     $suratjalan->status = $request->status;
    //     $suratjalan->latitude = $paket->sender_latitude;
    //     $suratjalan->longitude = $paket->sender_longitude;
    //     $suratjalan->save();

    //     return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil diupdate.');
    // }

    // public function destroy($id)
    // {
    //     $suratjalan = SuratJalan::findOrFail($id);
        
    //     $suratjalan->delete();

    //     return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil dihapus.');
    // }
}
