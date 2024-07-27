<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckpointOperatorController extends Controller
{
    public function index()
    {
        $checkpoints = Checkpoint::paginate(10);
    
        return view('operator.checkpoint.index', compact('checkpoints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
        ], [
            'latitude.required' => 'Latitude harus diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'longitude.required' => 'Longitude harus diisi.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'address.required' => 'Address harus diisi.',
            'address.string' => 'Address harus berupa teks.',
        ]);

        try {
            $checkpoint = new Checkpoint();
            $checkpoint->id = Str::uuid();
            $checkpoint->latitude = $request->latitude;
            $checkpoint->longitude = $request->longitude;
            $checkpoint->address = $request->address;
            $checkpoint->save();

            return response()->json(['success' => true, 'checkpoint' => $checkpoint, 'message' => 'Checkpoint berhasil disimpan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan checkpoint: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $checkpoint = Checkpoint::findOrFail($id);
            $checkpoint->delete();

            return redirect()->route('operator.checkpoint.index')->with('success', 'Checkpoint berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('operator.checkpoint.index')->with('error', 'Gagal menghapus checkpoint: ' . $e->getMessage());
        }
    }
}
