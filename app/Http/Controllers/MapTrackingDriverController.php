<?php
namespace App\Http\Controllers;

use App\Models\SuratJalan;
use Illuminate\Http\Request;

class MapTrackingDriverController extends Controller
{
    public function show($id)
    {
        $suratJalan = SuratJalan::with(['driver'])->findOrFail($id);

        // Decode JSON strings to arrays, or initialize as empty arrays if null
        $suratJalan->checkpoint_latitude = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $suratJalan->checkpoint_longitude = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        return view('driver.maptracking.show', compact('suratJalan'));
    }

    public function addCheckpoint(Request $request, $id)
    {
        $suratJalan = SuratJalan::findOrFail($id);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Decode JSON strings to arrays, or initialize as empty arrays if null
        $checkpointLatitudes = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $checkpointLongitudes = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        // Append new coordinates
        $checkpointLatitudes[] = $latitude;
        $checkpointLongitudes[] = $longitude;

        // Encode arrays back to JSON strings
        $suratJalan->checkpoint_latitude = json_encode($checkpointLatitudes);
        $suratJalan->checkpoint_longitude = json_encode($checkpointLongitudes);
        $suratJalan->save();

        return response()->json(['success' => true]);
    }
}
