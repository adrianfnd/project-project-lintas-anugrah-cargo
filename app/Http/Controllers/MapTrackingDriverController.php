<?php
namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Paket;
use Illuminate\Http\Request;

class MapTrackingDriverController extends Controller
{
    public function show($id)
    {
        $suratJalan = SuratJalan::with(['driver'])->findOrFail($id);

        $suratJalan->checkpoint_latitude = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $suratJalan->checkpoint_longitude = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        $paketIds = json_decode($suratJalan->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $suratJalan->list_paket = json_encode($list_paket);

        return view('driver.maptracking.show', compact('suratJalan', 'list_paket', 'list_paket_ids'));
    }

    public function addCheckpoint(Request $request, $id)
    {
        $suratJalan = SuratJalan::findOrFail($id);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $checkpointLatitudes = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $checkpointLongitudes = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        $checkpointLatitudes[] = $latitude;
        $checkpointLongitudes[] = $longitude;

        $suratJalan->checkpoint_latitude = json_encode($checkpointLatitudes);
        $suratJalan->checkpoint_longitude = json_encode($checkpointLongitudes);
        $suratJalan->save();

        return response()->json(['success' => true]);
    }
}
