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
        $suratjalans = SuratJalan::with(['driver'])
                        ->orderByRaw("FIELD(status, 'proses', 'dikirim', 'sampai')")
                        ->where('status', 'proses')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('operator.suratjalan.index', compact('suratjalans'));
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

        return view('operator.suratjalan.detail', compact('suratjalan', 'list_paket', 'list_paket_ids'));
    }

    public function create()
    {
        $drivers = Driver::where('status', 'menunggu')->get();
        $pakets = Paket::where('status', 'diinput')->get();

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

        $suratJalan->id = (string) Str::uuid();
        $suratJalan->driver_id = $request->input('driver');
        $suratJalan->sender = $request->input('sender');
        $suratJalan->sender_latitude = $request->input('sender_latitude');
        $suratJalan->sender_longitude = $request->input('sender_longitude');
        $suratJalan->receiver = $request->input('receiver');
        $suratJalan->receiver_latitude = $request->input('receiver_latitude');
        $suratJalan->receiver_longitude = $request->input('receiver_longitude');
        $suratJalan->list_paket = $request->input('list_paket');
        $suratJalan->status = 'proses';
        $suratJalan->estimated_delivery_time = $this->calculateEstimatedDeliveryTime(
            $suratJalan->sender_latitude,
            $suratJalan->sender_longitude,
            $suratJalan->receiver_latitude,
            $suratJalan->receiver_longitude
        );

        $suratJalan->save();

        $paketIds = json_decode($request->input('list_paket'), true);
        Paket::whereIn('id', $paketIds)->update([
            'surat_jalan_id' => $suratJalan->id,
            'status' => 'proses'
        ]);

        session()->forget('pakets');

        return redirect()->route('operator.suratjalan.index')->with('success', 'Surat Jalan berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $drivers = Driver::where('status', 'menunggu')->get();
        $pakets = Paket::where('status', 'diinput')->get();

        $suratjalan = SuratJalan::with(['driver'])
                        ->where('status', 'proses')
                        ->where('id', $id)
                        ->firstOrFail();

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
    
        $suratJalan = SuratJalan::where('id', $id)->where('status', 'proses')->firstOrFail();

        $existingPaketIds = json_decode($suratJalan->list_paket, true);
        Paket::whereIn('id', $existingPaketIds)->update([
            'surat_jalan_id' => null,
            'status' => 'diinput'
        ]);
    
        $suratJalan->driver_id = $request->input('driver');
        $suratJalan->sender = $request->input('sender');
        $suratJalan->sender_latitude = $request->input('sender_latitude');
        $suratJalan->sender_longitude = $request->input('sender_longitude');
        $suratJalan->receiver = $request->input('receiver');
        $suratJalan->receiver_latitude = $request->input('receiver_latitude');
        $suratJalan->receiver_longitude = $request->input('receiver_longitude');
        $suratJalan->list_paket = $request->input('list_paket');
        $suratJalan->status = 'proses';
        $suratJalan->estimated_delivery_time = $this->calculateEstimatedDeliveryTime(
            $suratJalan->sender_latitude,
            $suratJalan->sender_longitude,
            $suratJalan->receiver_latitude,
            $suratJalan->receiver_longitude
        );    
    
        $suratJalan->save();
    
        $newPaketIds = json_decode($request->input('list_paket'), true);
        Paket::whereIn('id', $newPaketIds)->update([
            'surat_jalan_id' => $suratJalan->id,
            'status' => 'proses'
        ]);
    
        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil diupdate.');
    }
    

    public function destroy($id)
    {
        $suratjalan = SuratJalan::where('id', $id)->where('status', 'proses')->firstOrFail();

        $paketIds = json_decode($suratjalan->list_paket, true);

        Paket::whereIn('id', $paketIds)->update([
            'surat_jalan_id' => null,
            'status' => 'diinput'
        ]);

        $suratjalan->delete();

        return redirect()->route('operator.suratjalan.index')->with('success', 'Data Surat Jalan berhasil dihapus.');
    }


    private function calculateEstimatedDeliveryTime($senderLat, $senderLon, $receiverLat, $receiverLon)
    {
        $earthRadius = 6371;
    
        $latDistance = deg2rad($receiverLat - $senderLat);
        $lonDistance = deg2rad($receiverLon - $senderLon);
    
        $a = sin($latDistance / 2) * sin($latDistance / 2) +
            cos(deg2rad($senderLat)) * cos(deg2rad($receiverLat)) *
            sin($lonDistance / 2) * sin($lonDistance / 2);
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;
    
        $speed = 30;
        $timeInHours = $distance / $speed;
    
        return round($timeInHours, 2);
    }

}
