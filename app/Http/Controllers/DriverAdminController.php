<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverAdminController extends Controller
{
    public function index()
    {
       $drivers = Driver::paginate(10);

       return view('admin.driver.index', compact('drivers'));
    }

    public function detail($id)
    {
        $driver = Driver::findOrFail($id);

        $user = User::where('driver_id', $driver->id)->firstOrFail();

        return view('admin.driver.detail', compact('driver', 'user'));
    }

    public function create()
    {
        return view('admin.driver.create');
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
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kolom password harus diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password_confirmation.required' => 'Kolom konfirmasi password harus diisi.',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password.',
            
            'name.required' => 'Kolom nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'image.required' => 'Kolom gambar harus diisi.',
            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Gambar harus memiliki format jpeg, png, jpg, atau gif.',
            'image.max' => 'Gambar tidak boleh lebih dari 2048 kilobyte.',
            'phone_number.required' => 'Kolom nomor hp harus diisi.',
            'phone_number.string' => 'Nomor hp harus berupa teks.',
            'phone_number.max' => 'Nomor hp tidak boleh lebih dari 255 karakter.',
            'phone_number.unique' => 'Nomor hp sudah terdaftar.',
            'license_number.required' => 'Kolom nomor plat kendaraan harus diisi.',
            'license_number.string' => 'Nomor plat kendaraan harus berupa teks.',
            'license_number.max' => 'Nomor plat kendaraan tidak boleh lebih dari 255 karakter.',
            'license_number.unique' => 'Nomor plat kendaraan sudah terdaftar.',
            'vehicle_name.required' => 'Kolom nama kendaraan harus diisi.',
            'vehicle_name.string' => 'Nama kendaraan harus berupa teks.',
            'vehicle_name.max' => 'Nama kendaraan tidak boleh lebih dari 255 karakter.',
            'address.required' => 'Kolom alamat harus diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.'
        ]);
        

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('public/drivers');
        }

        $driver = new Driver();
        $driver->created_by = auth()->user()->admin_id;
        $driver->name = $request->name;
        $driver->phone_number = $request->phone_number;
        $driver->license_number = $request->license_number;
        $driver->vehicle_name = $request->vehicle_name;
        $driver->address = $request->address;
        if ($request->hasFile('image')) {
            $driver->image = basename($imageName);
        }
        $driver->save();

        $user = new User();
        $user->driver_id = $driver->id;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->phone_number);
        $user->role_id = 4;
        $user->save();

        return redirect()->route('admin.driver.index')->with('success', 'Data Driver berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);

        $user = User::where('driver_id', $driver->id)->firstOrFail();

        return view('admin.driver.edit', compact('driver', 'user'));
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
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password_confirmation.same' => 'Konfirmasi password tidak sama.',

            'name.required' => 'Kolom nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Gambar harus memiliki format jpeg, png, jpg, atau gif.',
            'image.max' => 'Gambar tidak boleh lebih dari 2048 kilobyte.',
            'phone_number.required' => 'Kolom nomor hp harus diisi.',
            'phone_number.string' => 'Nomor hp harus berupa teks.',
            'phone_number.max' => 'Nomor hp tidak boleh lebih dari 255 karakter.',
            'phone_number.unique' => 'Nomor hp sudah terdaftar.',
            'license_number.required' => 'Kolom nomor plat kendaraan harus diisi.',
            'license_number.string' => 'Nomor plat kendaraan harus berupa teks.',
            'license_number.max' => 'Nomor plat kendaraan tidak boleh lebih dari 255 karakter.',
            'license_number.unique' => 'Nomor plat kendaraan sudah terdaftar.',
            'vehicle_name.required' => 'Kolom nama kendaraan harus diisi.',
            'vehicle_name.string' => 'Nama kendaraan harus berupa teks.',
            'vehicle_name.max' => 'Nama kendaraan tidak boleh lebih dari 255 karakter.',
            'address.required' => 'Kolom alamat harus diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
        ]);

        $driver->name = $request->name;
        $driver->phone_number = $request->phone_number;
        $driver->license_number = $request->license_number;
        $driver->vehicle_name = $request->vehicle_name;
        $driver->address = $request->address;

        if ($request->hasFile('image')) {
            Storage::delete('public/drivers/' . $driver->image);
            $imageName = $request->file('image')->store('public/drivers');
            $driver->image = basename($imageName);
        }

        $driver->save();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.driver.index')->with('success', 'Data Driver berhasil diupdate.');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        if ($driver->image) {
            Storage::delete('public/drivers/' . $driver->image);
        }

        $driver->delete();

        return redirect()->route('admin.driver.index')->with('success', 'Data Driver berhasil dihapus.');
    }
}
