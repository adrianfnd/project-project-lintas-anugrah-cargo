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
        $radius = 0.001; // Radius in degrees (approx 100 meters)

        $checkpointLatitudes = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $checkpointLongitudes = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        foreach ($checkpointLatitudes as $index => $checkpointLatitude) {
            $checkpointLongitude = $checkpointLongitudes[$index];
            $distance = $this->haversineGreatCircleDistance($latitude, $longitude, $checkpointLatitude, $checkpointLongitude);

            if ($distance < $radius) {
                return response()->json(['success' => false, 'message' => 'Checkpoint already exists at this location'], 400);
            }
        }

        $checkpointLatitudes[] = $latitude;
        $checkpointLongitudes[] = $longitude;

        $suratJalan->checkpoint_latitude = json_encode($checkpointLatitudes);
        $suratJalan->checkpoint_longitude = json_encode($checkpointLongitudes);
        $suratJalan->save();

        return response()->json(['success' => true]);
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}
