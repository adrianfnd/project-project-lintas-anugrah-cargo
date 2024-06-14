<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaketOperatorController extends Controller
{
    public function index()
    {
        $pakets = Paket::paginate(10);

        return view('operator.paket.index', compact('pakets'));
    }

    public function create()
    {
        return view('operator.paket.create');
    }

    public function detail($id)
    {
        $paket = Paket::findOrFail($id);

        return view('operator.paket.detail', compact('paket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_address' => 'required|string|max:255',
            'sender_latitude' => 'required|numeric',
            'sender_longitude' => 'required|numeric',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'receiver_latitude' => 'required|numeric',
            'receiver_longitude' => 'required|numeric',
            'weight' => 'required|numeric',
            'dimensions' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('public/pakets');
        }

        $paket = new Paket();
        $paket->id = Str::uuid();
        $paket->tracking_number = rand(100000, 999999);
        $paket->sender_name = $request->sender_name;
        $paket->sender_address = $request->sender_address;
        $paket->sender_latitude = $request->sender_latitude;
        $paket->sender_longitude = $request->sender_longitude;
        $paket->receiver_name = $request->receiver_name;
        $paket->receiver_address = $request->receiver_address;
        $paket->receiver_latitude = $request->receiver_latitude;
        $paket->receiver_longitude = $request->receiver_longitude;
        $paket->weight = $request->weight;
        $paket->dimensions = $request->dimensions;
        $paket->description = $request->description;
        $paket->status = 'proses';
        // if ($request->hasFile('image')) {
        //     $paket->image = basename($imageName);
        // }
        $paket->image = 'test.jpg';
        $paket->save();

        return redirect()->route('operator.paket.index')->with('success', 'Data Paket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);

        return view('operator.paket.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'tracking_number' => 'required|unique:pakets,tracking_number,' . $id,
            'sender_name' => 'required|string|max:255',
            'sender_address' => 'required|string|max:255',
            'sender_latitude' => 'required|numeric',
            'sender_longitude' => 'required|numeric',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'receiver_latitude' => 'required|numeric',
            'receiver_longitude' => 'required|numeric',
            'weight' => 'required|numeric',
            'dimensions' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:255'
        ]);

        $paket->tracking_number = $request->tracking_number;
        $paket->sender_name = $request->sender_name;
        $paket->sender_address = $request->sender_address;
        $paket->sender_latitude = $request->sender_latitude;
        $paket->sender_longitude = $request->sender_longitude;
        $paket->receiver_name = $request->receiver_name;
        $paket->receiver_address = $request->receiver_address;
        $paket->receiver_latitude = $request->receiver_latitude;
        $paket->receiver_longitude = $request->receiver_longitude;
        $paket->weight = $request->weight;
        $paket->dimensions = $request->dimensions;
        $paket->description = $request->description;
        $paket->status = $request->status;
        if ($request->hasFile('image')) {
            Storage::delete('public/pakets/' . $paket->image);
            $imageName = $request->file('image')->store('public/pakets');
            $paket->image = basename($imageName);
        }
        $paket->save();

        return redirect()->route('operator.paket.index')->with('success', 'Data Paket berhasil diupdate.');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);

        if ($paket->image) {
            Storage::delete('public/pakets/' . $paket->image);
        }

        $paket->delete();

        return redirect()->route('operator.paket.index')->with('success', 'Data Paket berhasil dihapus.');
    }
}
