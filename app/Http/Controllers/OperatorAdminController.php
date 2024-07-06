<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Operator;

class OperatorAdminController extends Controller
{
    public function index(Request $request)
    {
        $operators = Operator::paginate(10);
    
        return view('admin.operator.index', compact('operators'));
    }
    
    public function detail($id)
    {
        $operator = Operator::findOrFail($id);

        $user = User::where('operator_id', $operator->id)->firstOrFail();

        return view('admin.operator.detail', compact('operator', 'user'));
    }

    public function create()
    {
        return view('admin.operator.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',

            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'region' => 'required|string|max:255',
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
            'phone_number.required' => 'Kolom nomor hp harus diisi.',
            'phone_number.string' => 'Nomor hp harus berupa teks.',
            'phone_number.max' => 'Nomor hp tidak boleh lebih dari 255 karakter.',
            'phone_number.unique' => 'Nomor hp sudah terdaftar.',
            'address.required' => 'Kolom alamat harus diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'region.required' => 'Kolom wilayah harus diisi.',
            'region.string' => 'Wilayah harus berupa teks.',
            'region.max' => 'Wilayah tidak boleh lebih dari 255 karakter.',
        ]);

        $operator = new Operator();
        $operator->created_by = auth()->user()->admin_id;
        $operator->name = $request->name;
        $operator->phone_number = $request->phone_number;
        $operator->address = $request->address;
        $operator->region = $request->region;
        $operator->region_latitude = $request->region_latitude;
        $operator->region_longitude = $request->region_longitude;
        $operator->save();

        $user = new User();
        $user->operator_id = $operator->id;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->role_id = 3;
        $user->save();

        return redirect()->route('admin.operator.index')->with('success', 'Data Operator berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $operator = Operator::findOrFail($id);

        $user = User::where('operator_id', $operator->id)->firstOrFail();

        return view('admin.operator.edit', compact('operator', 'user'));
    }

    public function update(Request $request, $id)
    {
        $operator = Operator::findOrFail($id);

        $user = User::where('operator_id', $operator->id)->firstOrFail();

        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8',
            'password_confirmation' => 'nullable|same:password',

            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:operators,phone_number,'.$id,
            'address' => 'required|string|max:255',
            'region' => 'required|string|max:255',
        ], [
            'username.required' => 'Kolom username harus diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password.',

            'name.required' => 'Kolom nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'phone_number.required' => 'Kolom nomor hp harus diisi.',
            'phone_number.string' => 'Nomor hp harus berupa teks.',
            'phone_number.max' => 'Nomor hp tidak boleh lebih dari 255 karakter.',
            'phone_number.unique' => 'Nomor hp sudah terdaftar.',
            'address.required' => 'Kolom alamat harus diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'region.required' => 'Kolom wilayah harus diisi.',
            'region.string' => 'Wilayah harus berupa teks.',
            'region.max' => 'Wilayah tidak boleh lebih dari 255 karakter.',
        ]);

        $operator->name = $request->name;
        $operator->phone_number = $request->phone_number;
        $operator->address = $request->address;
        $operator->region = $request->region;
        $operator->region_latitude = $request->region_latitude;
        $operator->region_longitude = $request->region_longitude;
        $operator->save();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('admin.operator.index')->with('success', 'Data Operator berhasil diupdate.');
    }

    public function destroy($id)
    {
        $driver = Operator::findOrFail($id);

        $driver->delete();

        return redirect()->route('admin.operator.index')->with('success', 'Data Operator berhasil dihapus.');
    }
}
