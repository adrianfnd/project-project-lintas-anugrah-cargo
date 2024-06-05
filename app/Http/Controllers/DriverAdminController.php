<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Storage;

class DriverAdminController extends Controller
{
    public function index()
    {
       $drivers = Driver::all();

       return view('admin.driver.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.driver.create');
    }

    public function detail()
    {
        return view('admin.driver.detail');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',

            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'requiredstring|max:255||unique:drivers',
            'license_number' => 'required|string|max:255|unique:drivers',
            'vehicle_name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        $imageName = $request->file('image')->store('public/drivers');

        $driver = new Driver();
        $user->created_by = auth()->user()->id;
        $driver->name = $request->name;
        $driver->image = basename($imageName);
        $driver->phone_number = $request->phone_number;
        $driver->license_number = $request->license_number;
        $driver->vehicle_name = $request->vehicle_name;
        $driver->address = $request->address;
        $driver->save();

        $user = new User();
        $user->driver_id = $driver->id;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->phone_number;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->phone_number);
        $user->role_id = 3;
        $user->save();

        return redirect()->route('admin.driver.index')->with('success', 'Data Driver berhasil ditambahkan.');
    }

    public function edit()
    {
        $driver = Driver::findOrFail($id);

        $user = User::where('driver_id', $driver->id)->firstOrFail();

        return view('admin.driver.edit', compact('driver', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:drivers,phone_number,'.$id,
            'license_number' => 'required|unique:drivers,license_number,'.$id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_name' => 'required',
            'address' => 'required',
            'rate' => 'required|integer',
        ]);

        $driver = Driver::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::delete('public/drivers/' . $driver->image);
            $imageName = $request->file('image')->store('public/drivers');
            $driver->image = basename($imageName);
        }

        $driver->name = $request->name;
        $driver->phone_number = $request->phone_number;
        $driver->license_number = $request->license_number;
        $driver->vehicle_name = $request->vehicle_name;
        $driver->address = $request->address;
        $driver->rate = $request->rate;
        $driver->save();

        $user = User::where('driver_id', $driver->id)->firstOrFail();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->phone_number;
        $user->save();

        return redirect()->route('admin.driver.index')->with('success', 'Data Driver berhasil diupdate.');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        Storage::delete('public/drivers/' . $driver->image);

        $driver->delete();

        return redirect()->route('admin.driver.index')->with('success', 'Data Driver berhasil dihapus.');
    }
}
