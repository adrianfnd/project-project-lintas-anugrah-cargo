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
        $pakets = Paket::orderByRaw("FIELD(status, 'diinput', 'proses', 'dikirim', 'sampai')")
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('operator.paket.index', compact('pakets'));
    }

    public function detail($id)
    {
        $paket = Paket::findOrFail($id);

        return view('operator.paket.detail', compact('paket'));
    }

    public function create()
    {
        return view('operator.paket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'packet_name' => 'required|string|max:255',
            'packet_type' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
            'sender_address' => 'required|string|max:255',
            'sender_phone' => 'required|numeric',
            'sender' => 'required',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'receiver_phone' => 'required|numeric',
            'receiver' => 'required',
            'weight' => 'required|numeric',
            'dimensions' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'packet_name.required' => 'Nama Paket harus diisi.',
            'packet_name.max' => 'Nama Paket maksimal :max karakter.',
            'packet_type.required' => 'Jenis Paket harus diisi.',
            'packet_type.max' => 'Jenis Paket maksimal :max karakter.',
            'sender_name.required' => 'Nama Pengirim harus diisi.',
            'sender_name.max' => 'Nama Pengirim maksimal :max karakter.',
            'sender_address.required' => 'Alamat Pengirim harus diisi.',
            'sender_address.max' => 'Alamat Pengirim maksimal :max karakter.',
            'sender_phone.required' => 'Nomor Telepon Pengirim harus diisi.',
            'sender_phone.numeric' => 'Nomor Telepon Pengirim harus berupa angka.',
            'sender.required' => 'Lokasi Pengirim harus diisi.',
            'receiver_name.required' => 'Nama Penerima harus diisi.',
            'receiver_name.max' => 'Nama Penerima maksimal :max karakter.',
            'receiver_address.required' => 'Alamat Penerima harus diisi.',
            'receiver_address.max' => 'Alamat Penerima maksimal :max karakter.',
            'receiver_phone.required' => 'Nomor Telepon Penerima harus diisi.',
            'receiver_phone.numeric' => 'Nomor Telepon Penerima harus berupa angka.',
            'receiver.required' => 'Lokasi Penerima harus diisi.',
            'weight.required' => 'Berat harus diisi.',
            'dimensions.required' => 'Dimensi harus diisi.',
            'dimensions.max' => 'Dimensi maksimal :max karakter.',
            'image.required' => 'Gambar harus diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal :max kilobyte.',
        ]);

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('public/pakets');
        }

        $paket = new Paket();
        $paket->id = Str::uuid();
        $paket->tracking_number = rand(10000000, 99999999);
        $paket->packet_name = $request->packet_name;
        $paket->packet_type = $request->packet_type;
        $paket->sender_name = $request->sender_name;
        $paket->sender_address = $request->sender_address;
        $paket->sender_phone = $request->sender_phone;
        $paket->sender_latitude = $request->sender_latitude;
        $paket->sender_longitude = $request->sender_longitude;
        $paket->receiver_name = $request->receiver_name;
        $paket->receiver_address = $request->receiver_address;
        $paket->receiver_phone = $request->receiver_phone;
        $paket->receiver_latitude = $request->receiver_latitude;
        $paket->receiver_longitude = $request->receiver_longitude;
        $paket->weight = $request->weight;
        $paket->dimensions = $request->dimensions;
        $paket->description = $request->description;
        $paket->status = 'diinput';
        if ($request->hasFile('image')) {
            $paket->image = basename($imageName);
        }
        $paket->created_by = auth()->user()->operator_id;
        $paket->save();

        return redirect()->route('operator.paket.index')->with('success', 'Data Paket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $paket = Paket::where('id', $id)->where('status', 'diinput')->firstOrFail();

        return view('operator.paket.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'packet_name' => 'required|string|max:255',
            'packet_type' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
            'sender_address' => 'required|string|max:255',
            'sender_phone' => 'required|numeric',
            'sender' => 'required',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'receiver_phone' => 'required|numeric',
            'receiver' => 'required',
            'weight' => 'required|numeric',
            'dimensions' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'packet_name.required' => 'Nama Paket harus diisi.',
            'packet_name.max' => 'Nama Paket maksimal :max karakter.',
            'packet_type.required' => 'Jenis Paket harus diisi.',
            'packet_type.max' => 'Jenis Paket maksimal :max karakter.',
            'sender_name.required' => 'Nama Pengirim harus diisi.',
            'sender_name.max' => 'Nama Pengirim maksimal :max karakter.',
            'sender_address.required' => 'Alamat Pengirim harus diisi.',
            'sender_address.max' => 'Alamat Pengirim maksimal :max karakter.',
            'sender_phone.required' => 'Nomor Telepon Pengirim harus diisi.',
            'sender_phone.numeric' => 'Nomor Telepon Pengirim harus berupa angka.',
            'sender.required' => 'Lokasi Pengirim harus diisi.',
            'receiver_name.required' => 'Nama Penerima harus diisi.',
            'receiver_name.max' => 'Nama Penerima maksimal :max karakter.',
            'receiver_address.required' => 'Alamat Penerima harus diisi.',
            'receiver_address.max' => 'Alamat Penerima maksimal :max karakter.',
            'receiver_phone.required' => 'Nomor Telepon Penerima harus diisi.',
            'receiver_phone.numeric' => 'Nomor Telepon Penerima harus berupa angka.',
            'receiver.required' => 'Lokasi Penerima harus diisi.',
            'weight.required' => 'Berat harus diisi.',
            'dimensions.required' => 'Dimensi harus diisi.',
            'dimensions.max' => 'Dimensi maksimal :max karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal :max kilobyte.',
        ]);
    
        $paket = Paket::where('id', $id)->where('status', 'diinput')->firstOrFail();
    
        $paket->packet_name = $request->packet_name;
        $paket->packet_type = $request->packet_type;
        $paket->sender_name = $request->sender_name;
        $paket->sender_address = $request->sender_address;
        $paket->sender_phone = $request->sender_phone;
        $paket->sender_latitude = $request->sender_latitude;
        $paket->sender_longitude = $request->sender_longitude;
        $paket->receiver_name = $request->receiver_name;
        $paket->receiver_address = $request->receiver_address;
        $paket->receiver_phone = $request->receiver_phone;
        $paket->receiver_latitude = $request->receiver_latitude;
        $paket->receiver_longitude = $request->receiver_longitude;
        $paket->weight = $request->weight;
        $paket->dimensions = $request->dimensions;
        $paket->description = $request->description;
    
        if ($request->hasFile('image')) {
            Storage::delete('public/pakets/' . $paket->image);
            $imageName = $request->file('image')->store('public/pakets');
            $paket->image = basename($imageName);
        }
    
        $paket->save();
    
        return redirect()->route('operator.paket.index')->with('success', 'Data Paket berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        $paket = Paket::where('id', $id)->where('status', 'diinput')->firstOrFail();

        if ($paket->image) {
            Storage::delete('public/pakets/' . $paket->image);
        }

        $paket->delete();

        return redirect()->route('operator.paket.index')->with('success', 'Data Paket berhasil dihapus.');
    }
}
