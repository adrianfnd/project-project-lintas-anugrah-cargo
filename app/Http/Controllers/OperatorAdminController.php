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
    public function create()
    {
        return view('admin.operator.create');
    }

    public function detail()
    {
        return view('admin.operator.detail');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',

            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'region' => 'required|string|max:255',
        ]);

        $operator = new Operator();
        // $operator->created_by = auth()->user()->id;
        $operator->created_by = "8ab471b9-3fa6-4419-bcd9-e49571a8ac59";
        $operator->name = $request->nama;
        $operator->phone_number = $request->nomor_hp;
        $operator->address = $request->alamat;
        $operator->region = $request->region;
        $operator->region_latitude = $request->region_latitude;
        $operator->region_longitude = $request->region_longitude;
        $operator->save();

        $user = new User();
        $user->operator_id = $operator->id;
        $user->name = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->role_id = 2;
        $user->save();

        return redirect()->route('operator.index')->with('success', 'Data Operator berhasil ditambahkan.');
    }


    public function edit()
    {
        // $operator = Operator::findOrFail($id);

        // $user = User::where('operator_id', $operator->id)->firstOrFail();

        // return view('admin.operator.edit', compact('operator', 'user'));
        return view('admin.operator.edit');
    }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'name' => 'required',
//             'phone_number' => 'required|unique:operators,phone_number,'.$id,
//             'address' => 'required',
//             'region' => 'required',
//         ]);

//         $operator = Operator::findOrFail($id);
//         $operator->name = $request->name;
//         $operator->phone_number = $request->phone_number;
//         $operator->address = $request->address;
//         $operator->region = $request->region;
//         $operator->region_latitude = $request->region_latitude;
//         $operator->region_longitude = $request->region_longitude;
//         $operator->save();

//         $user = User::where('operator_id', $operator->id)->firstOrFail();
//         $user->name = $request->name;
//         $user->username = $request->username;
//         $user->email = $request->phone_number;
//         $user->save();

//         return redirect()->route('admin.operator.index')->with('success', 'Data Operator berhasil diupdate.');
//     }

//     public function destroy($id)
//     {
//         $driver = Operator::findOrFail($id);

//         $driver->delete();

//         return redirect()->route('admin.operator.index')->with('success', 'Data Operator berhasil dihapus.');
//     }
}
