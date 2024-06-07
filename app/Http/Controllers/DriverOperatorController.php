<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverOperatorController extends Controller
{
    public function index()
    {
       $drivers = Driver::paginate(10);

       return view('operator.driver.index', compact('drivers'));
    }

    public function create()
    {
        return view('operator.driver.create');
    }

    public function detail($id)
    {
        $driver = Driver::findOrFail($id);

        $user = User::where('driver_id', $driver->id)->firstOrFail();

        return view('operator.driver.detail', compact('driver', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',

            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|string|max:255|unique:drivers',
            'license_number' => 'required|string|max:255|unique:drivers',
            'vehicle_name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        $imageName = $request->file('image')->store('public/drivers');

        $driver = new Driver();
        $driver->created_by = auth()->user()->id;
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
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->role_id = 3;
        $user->save();

        return redirect()->route('operator.driver.index')->with('success', 'Data Driver berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);

        $user = User::where('driver_id', $driver->id)->firstOrFail();

        return view('operator.driver.edit', compact('driver', 'user'));
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $user = User::where('driver_id', $driver->id)->firstOrFail();

        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8',
            'password_confirmation' => 'nullable|same:password',

            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required|unique:drivers,phone_number,'.$id,
            'license_number' => 'required|unique:drivers,license_number,'.$id,
            'vehicle_name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        $driver->name = $request->name;
        if ($request->hasFile('image')) {
            Storage::delete('public/drivers/' . $driver->image);
            $imageName = $request->file('image')->store('public/drivers');
            $driver->image = basename($imageName);
        }
        $driver->phone_number = $request->phone_number;
        $driver->license_number = $request->license_number;
        $driver->vehicle_name = $request->vehicle_name;
        $driver->address = $request->address;
        $driver->save();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('operator.driver.index')->with('success', 'Data Driver berhasil diupdate.');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        Storage::delete('public/drivers/' . $driver->image);
        
        $driver->delete();

        return redirect()->route('operator.driver.index')->with('success', 'Data Driver berhasil dihapus.');
    }
}
