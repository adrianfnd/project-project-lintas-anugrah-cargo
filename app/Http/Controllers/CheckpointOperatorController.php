<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckpointOperatorController extends Controller
{
    public function index()
    {
        $checkpoints = Checkpoint::paginate(10); // Menambahkan pagination dengan 10 item per halaman
        return view('operator.checkpoint.index', compact('checkpoints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'required|string|max:255',
        ]);

        $checkpoint = new Checkpoint();
        $checkpoint->id = Str::uuid();
        $checkpoint->latitude = $request->latitude;
        $checkpoint->longitude = $request->longitude;
        $checkpoint->address = $request->address;
        $checkpoint->save();

        return response()->json(['success' => true, 'checkpoint' => $checkpoint]);
    }

    public function destroy($id)
    {
        $checkpoint = Checkpoint::findOrFail($id);
        $checkpoint->delete();

        return redirect()->route('operator.checkpoint.index')->with('success', 'Checkpoint deleted successfully.');
    }
}
