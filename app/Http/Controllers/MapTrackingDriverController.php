<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\RiwayatPaket;

class MapTrackingDriverController extends Controller
{
    public function showTrackingMap($id)
    {
        $suratJalan = SuratJalan::with(['paket'])->findOrFail($id);
        return view('driver.maptracking.show', compact('suratJalan'));
    }

    public function checkpoint(Request $request, $id)
    {
        $suratJalan = SuratJalan::findOrFail($id);
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        if ($this->isValidCheckpoint($suratJalan, $latitude, $longitude)) {
            $checkpoints = json_decode($suratJalan->checkpoints, true) ?? [];
            $checkpoints[] = ['latitude' => $latitude, 'longitude' => $longitude];
            $suratJalan->checkpoints = json_encode($checkpoints);
            $suratJalan->save();

            return response()->json(['success' => true, 'message' => 'Checkpoint added successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid checkpoint location.']);
    }

    public function completeDelivery(Request $request, $id)
    {
        $suratJalan = SuratJalan::findOrFail($id);
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        if ($this->isNearReceiver($suratJalan, $latitude, $longitude)) {
            $suratJalan->status = 'delivered';
            $suratJalan->save();

            $riwayatPaket = new RiwayatPaket();
            $riwayatPaket->driver_id = $suratJalan->driver_id;
            $riwayatPaket->paket_id = $suratJalan->paket_id;
            $riwayatPaket->surat_jalan_id = $suratJalan->id;
            $riwayatPaket->status = 'delivered';
            $riwayatPaket->save();

            return response()->json(['success' => true, 'message' => 'Delivery completed successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Not near receiver location.']);
    }

    private function isValidCheckpoint(SuratJalan $suratJalan, $latitude, $longitude)
    {
        return true;
    }

    private function isNearReceiver(SuratJalan $suratJalan, $latitude, $longitude)
    {
        return true;
    }
}
