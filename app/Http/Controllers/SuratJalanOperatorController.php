<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Driver;
use App\Models\Paket;

class SuratJalanController extends Controller
{
    public function index()
    {
        $suratjalans = SuratJalan::with(['driver', 'paket'])->paginate(10);

        return view('operator.suratjalan.index', compact('suratjalans'));
    }

    public function create()
    {
        $drivers = Driver::all();
        
        $pakets = Paket::all();

        return view('operator.suratjalan.create', compact('drivers', 'pakets'));
    }

    public function detail($id)
    {
        $suratjalan = SuratJalan::with(['driver', 'paket'])->findOrFail($id);

        return view('operator.suratjalan.detail', compact('suratjalan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'paket_id' => 'required|exists:pakets,id',
            'status' => 'required|string|max:255'
        ]);

        $paket = Paket::findOrFail($request->paket_id);

        $suratjalan = new SuratJalan();
        $suratjalan->driver_id = $request->driver_id;
        $suratjalan->paket_id = $request->paket_id;
        $suratjalan->status = $request->status;
        $suratjalan->latitude = $paket->sender_latitude;
        $suratjalan->longitude = $paket->sender_longitude;
        $suratjalan->save();

        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $suratjalan = SuratJalan::findOrFail($id);
        $drivers = Driver::all();
        $pakets = Paket::all();

        return view('operator.suratjalan.edit', compact('suratjalan', 'drivers', 'pakets'));
    }

    public function update(Request $request, $id)
    {
        $suratjalan = SuratJalan::findOrFail($id);

        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'paket_id' => 'required|exists:pakets,id',
            'status' => 'required|string|max:255'
        ]);

        $paket = Paket::findOrFail($request->paket_id);

        $suratjalan->driver_id = $request->driver_id;
        $suratjalan->paket_id = $request->paket_id;
        $suratjalan->status = $request->status;
        $suratjalan->latitude = $paket->sender_latitude;
        $suratjalan->longitude = $paket->sender_longitude;
        $suratjalan->save();

        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $suratjalan = SuratJalan::findOrFail($id);
        
        $suratjalan->delete();

        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil dihapus.');
    }
}
