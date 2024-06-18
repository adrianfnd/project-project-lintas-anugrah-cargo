<?php
namespace App\Http\Controllers;

use App\Models\SuratJalan;
use Illuminate\Http\Request;

class MapTrackingDriverController extends Controller
{
    public function show($id)
    {
        $suratJalan = SuratJalan::with(['driver'])->findOrFail($id);

        $suratJalan->checkpoint_latitude = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $suratJalan->checkpoint_longitude = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        return view('driver.maptracking.show', compact('suratJalan'));
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
