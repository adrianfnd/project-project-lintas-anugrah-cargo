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
        $suratjalans = SuratJalan::with(['driver'])->paginate(10);

        return view('operator.suratjalan.index', compact('suratjalans'));
    }

    public function detail($id)
    {
        $suratjalan = SuratJalan::with(['driver'])->findOrFail($id);

        $paketIds = json_decode($suratjalan->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $suratjalan->list_paket = json_encode($list_paket);

        return view('operator.suratjalan.detail', compact('suratjalan', 'list_paket', 'list_paket_ids'));
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
            'list_paket' => 'required|string',
            'sender' => 'required',
            'receiver' => 'required',
        ], [
            'driver.required' => 'Kolom driver harus diisi.',
            'driver.exists' => 'Driver yang dipilih tidak valid.',
            'list_paket.required' => 'Kolom List Paket harus diisi.',
            'sender.required' => 'Kolom Pengirim harus diisi.',
            'receiver.required' => 'Kolom Penerima harus diisi.',
        ]);

        $suratJalan = new SuratJalan;

        $suratJalan->id = Str::uuid();
        $suratJalan->driver_id = $request->input('driver');
        $suratJalan->sender_latitude = $request->input('sender_latitude');
        $suratJalan->sender_longitude = $request->input('sender_longitude');
        $suratJalan->receiver_latitude = $request->input('receiver_latitude');
        $suratJalan->receiver_longitude = $request->input('receiver_longitude');
        $suratJalan->list_paket = $request->input('list_paket');
        $suratJalan->status = 'dikirim';

        $suratJalan->save();
    
        session()->forget('pakets');
    
        return redirect()->route('operator.suratjalan.index')->with('success', 'Surat Jalan berhasil ditambahkan.');
    }
    

    public function edit($id)
    {
        $drivers = Driver::all();
        $pakets = Paket::all();
        // $pakets = Paket::where('status', 'diinput')->get();

        $suratjalan = SuratJalan::with(['driver'])->findOrFail($id);

        $paketIds = json_decode($suratjalan->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $suratjalan->list_paket = json_encode($list_paket);
    
        return view('operator.suratjalan.edit', compact('suratjalan', 'drivers', 'pakets', 'list_paket', 'list_paket_ids'));
    }
    

    public function update(Request $request, $id)
    {  
        $request->validate([
            'driver' => 'required|exists:drivers,id',
            'list_paket' => 'required|string',
            'sender' => 'required',
            'receiver' => 'required',
        ], [
            'driver.required' => 'Kolom driver harus diisi.',
            'driver.exists' => 'Driver yang dipilih tidak valid.',
            'list_paket.required' => 'Kolom List Paket harus diisi.',
            'sender.required' => 'Kolom Pengirim harus diisi.',
            'receiver.required' => 'Kolom Penerima harus diisi.',
        ]);

        $suratjalan = SuratJalan::findOrFail($id);

        $paket = Paket::find($request->paket);

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
}
