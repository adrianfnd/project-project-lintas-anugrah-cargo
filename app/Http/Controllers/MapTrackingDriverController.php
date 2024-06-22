<?php
namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Paket;
use App\Models\Driver;
use App\Models\Laporan;
use App\Models\RiwayatPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MapTrackingDriverController extends Controller
{
    public function show($id)
    {
        $suratJalan = SuratJalan::with(['driver'])
                        ->where('id', $id)
                        ->where('status', 'dikirim')
                        ->firstOrFail();

        $suratJalan->checkpoint_latitude = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $suratJalan->checkpoint_longitude = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        $paketIds = json_decode($suratJalan->list_paket, true);
        $paketList = Paket::whereIn('id', $paketIds)->get();
        $list_paket = $paketList->toArray();
        $list_paket_ids = array_column($list_paket, 'id');
        $suratJalan->list_paket = json_encode($list_paket);

        return view('driver.maptracking.show', compact('suratJalan', 'list_paket', 'list_paket_ids'));
    }

    public function cancel(Request $request, $id)
    {
        $suratJalan = SuratJalan::where('id', $id)
                        ->where('status', 'dikirim')
                        ->firstOrFail();

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = 0.001;

        $senderLatitude = $suratJalan->sender_latitude;
        $senderLongitude = $suratJalan->sender_longitude;

        // Check lokasi apakah dalam radius dari lokasi sender
        $distanceFromSender = $this->haversineGreatCircleDistance($latitude, $longitude, $senderLatitude, $senderLongitude);
        if ($distanceFromSender > $radius) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa dibatalkan, anda sudah berada diluar radius pengirim.'], 400);
        }

        $paketIds = json_decode($suratJalan->list_paket, true);
        Paket::whereIn('id', $paketIds)->update(['status' => 'proses']);

        $driver = Driver::findOrFail($suratJalan->driver_id);
        $driver->status = 'menunggu';
        $driver->save();

        $suratJalan->status = 'proses';
        $suratJalan->save();

        return response()->json(['success' => true, 'message' => 'Pengiriman berhasil dibatalkan.']);
    }

    public function addCheckpoint(Request $request, $id)
    {
        $suratJalan = SuratJalan::where('id', $id)
                        ->where('status', 'dikirim')
                        ->firstOrFail();

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = 0.001;

        $senderLatitude = $suratJalan->sender_latitude;
        $senderLongitude = $suratJalan->sender_longitude;
        $receiverLatitude = $suratJalan->receiver_latitude;
        $receiverLongitude = $suratJalan->receiver_longitude;

        // Check lokasi apakah melebihi dari lokasi sender
        $distanceFromSender = $this->haversineGreatCircleDistance($latitude, $longitude, $senderLatitude, $senderLongitude);
        if ($distanceFromSender < $radius) {
            return response()->json(['success' => false, 'message' => 'Checkpoint terlalu dekat dari pengirim'], 400);
        }

        // Check lokasi apakah melebihi dari lokasi receiver
        $distanceFromReceiver = $this->haversineGreatCircleDistance($latitude, $longitude, $receiverLatitude, $receiverLongitude);
        if ($distanceFromReceiver < $radius) {
            return response()->json(['success' => false, 'message' => 'Checkpoint terlalu dekat dari penerima'], 400);
        }

        $checkpointLatitudes = json_decode($suratJalan->checkpoint_latitude, true) ?? [];
        $checkpointLongitudes = json_decode($suratJalan->checkpoint_longitude, true) ?? [];

        // Check lokasi apakah melebihi dari lokasi checkpoints sekarang
        foreach ($checkpointLatitudes as $index => $checkpointLatitude) {
            $checkpointLongitude = $checkpointLongitudes[$index];
            $distance = $this->haversineGreatCircleDistance($latitude, $longitude, $checkpointLatitude, $checkpointLongitude);

            if ($distance < $radius) {
                return response()->json(['success' => false, 'message' => 'Anda sudah membuat checkpoint dilokasi ini'], 400);
            }
        }

        $checkpointLatitudes[] = $latitude;
        $checkpointLongitudes[] = $longitude;

        $suratJalan->checkpoint_latitude = json_encode($checkpointLatitudes);
        $suratJalan->checkpoint_longitude = json_encode($checkpointLongitudes);
        $suratJalan->save();

        return response()->json(['success' => true]);
    }

    public function finish(Request $request, $id)
    {
        $request->validate([
            'keluhan' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'keluhan.max' => 'Keluhan maksimal 255 karakter.',
            'images.*.max' => 'File maksimal 2 MB.',
            'images.*.mimes' => 'File harus berupa jpeg, png, jpg.',
            'images.*.image' => 'File harus berupa gambar.',
        ]);

        $suratJalan = SuratJalan::where('id', $id)
                        ->where('status', 'dikirim')
                        ->firstOrFail();

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = 0.001;

        $receiverLatitude = $suratJalan->receiver_latitude;
        $receiverLongitude = $suratJalan->receiver_longitude;

        // Check lokasi apakah dalam radius dari lokasi receiver
        $distanceFromReceiver = $this->haversineGreatCircleDistance($latitude, $longitude, $receiverLatitude, $receiverLongitude);
        if ($distanceFromReceiver < $radius) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berada didalam radius penerima'], 400);
        }

        if ($request->has('keluhan') and $request->hasFile('images')) {
            $laporan = new Laporan();
            $laporan->id = Str::uuid();
            $laporan->driver_id = $suratJalan->driver_id;
            $laporan->surat_jalan_id = $suratJalan->id;
            $laporan->keluhan = $request->input('keluhan', '');

            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/laporan');
                    $images[] = basename($path);
                }
                $laporan->image = json_encode($images);
            }

            $laporan->save();
        }

        $riwayatPaket = new RiwayatPaket();
        $riwayatPaket->id = Str::uuid();
        $riwayatPaket->driver_id = $suratJalan->driver_id;
        $riwayatPaket->list_paket = $suratJalan->list_paket;
        $riwayatPaket->surat_jalan_id = $suratJalan->id;
        $riwayatPaket->laporan_id = $laporan->id ?? null;
        $riwayatPaket->status = 'sampai';
        $riwayatPaket->save();

        $paketIds = json_decode($suratJalan->list_paket, true);
        Paket::whereIn('id', $paketIds)->update([
            'surat_jalan_id' => $suratJalan->id,
            'status' => 'sampai',
        ]);

        $suratJalan->end_delivery_time = now();
        $suratJalan->status = 'sampai';
        $suratJalan->save();

        $rating = $this->calculateDriverRating($suratJalan->start_delivery_time, $suratJalan->end_delivery_time, $suratJalan->estimated_delivery_time);

        $driver = Driver::findOrFail($suratJalan->driver_id);
        if ($driver->rate !== null) {
            $newRating = ($driver->rate + $rating) / 2;
            $driver->rate = round($newRating);
        } else {
            $driver->rate = $rating;
        }
        $driver->status = 'menunggu';
        $driver->save();

        return redirect()->route('driver.suratjalan.index')->with('success', 'Surat jalan selesai.');
    }

    private function calculateDriverRating($startDeliveryTime, $endDeliveryTime, $estimatedDeliveryTime)
    {
        $start = Carbon::parse($startDeliveryTime);
        $end = Carbon::parse($endDeliveryTime);
        $estimated = Carbon::parse($estimatedDeliveryTime);

        $hoursDifference = $end->diffInHours($estimated);

        if ($hoursDifference <= 0) {
            return 5;
        } elseif ($hoursDifference <= 2) {
            return 4;
        } elseif ($hoursDifference <= 4) {
            return 3;
        } elseif ($hoursDifference <= 6) {
            return 2;
        } else {
            return 1;
        }
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


