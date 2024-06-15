<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\Driver;
use App\Models\Paket;
use Illuminate\Support\Str;

class SuratJalanOperatorController extends Controller
{
    public function index()
    {
        $suratjalans = SuratJalan::with(['driver', 'paket'])->paginate(10);

        return view('operator.suratjalan.index', compact('suratjalans'));
    }

    public function detail()
    {
        $suratjalan = SuratJalan::with(['driver', 'paket'])->findOrFail($id);

        return view('operator.suratjalan.detail', compact('suratjalan'));
    }

    public function create()
    {
        $drivers = Driver::all();
        
        $pakets = Paket::all();

        return view('operator.suratjalan.create', compact('drivers', 'pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver' => 'required|exists:drivers,id',
            'paket' => 'required|exists:paket,id',
        ]);

        $paket = Paket::findOrFail($request->paket);

        $suratjalan = new SuratJalan();
        $suratjalan->id = Str::uuid();
        $suratjalan->driver_id = $request->driver;
        $suratjalan->paket_id = $request->paket;
        $suratjalan->status = 'dikirim';
        $suratjalan->save();

        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil ditambahkan.');
    }

    public function edit()
    {
        $suratjalan = SuratJalan::findOrFail($id);

        $drivers = Driver::all();

        $pakets = Paket::all();

        return view('operator.suratjalan.edit', compact('suratjalan', 'drivers', 'pakets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'driver' => 'required|exists:drivers,id',
            'paket' => 'required|exists:paket,id',
        ]);

        $suratjalan = SuratJalan::findOrFail($id);

        $paket = Paket::findOrFail($request->paket);

        $suratjalan->driver_id = $request->driver;
        $suratjalan->paket_id = $request->paket;
        $suratjalan->status = 'dikirim';
        $suratjalan->save();

        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $suratjalan = SuratJalan::findOrFail($id);
        
        $suratjalan->delete();

        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil dihapus.');
    }

    public function searchDrivers(Request $request)
    {
        $query = $request->get('query');
        $drivers = Driver::where('name', 'like', "%{$query}%")
                        ->orWhere('phone_number', 'like', "%{$query}%")
                        ->get();

        return response()->json($drivers);
    }

    public function searchPakets(Request $request)
    {
        $query = $request->get('query');
        $pakets = Paket::where('packet_name', 'like', "%{$query}%")
                        ->orWhere('tracking_number', 'like', "%{$query}%")
                        ->get();

        return response()->json($pakets);
    }
}
