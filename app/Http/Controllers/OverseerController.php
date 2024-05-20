<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OverseerController extends Controller
{
    public function index(){
        $users = User::all();
        return view('overseer.index', compact('users'));
    }

    public function create(){
        $wilayahs = Wilayah::all();
        return view('overseer.create', compact('wilayahs'));
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required',
            'nik' => 'required',
            'name' => 'required',
            'password' => 'required',
            'wilayah_id' => 'exists:wilayahs,id',
            'status' => 'required',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'wilayah_id' => $request->wilayah_id,
            'nik' => $request->nik,
            'status' => $request->status
        ]);

        return redirect()->route('overseer.index')
                         ->with('success', 'Penanggung Jawab created successfully.');
    }

    public function edit(User $user){
        $wilayahs = Wilayah::all();
        return view('overseer.edit', compact('user', 'wilayahs'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'username' => 'required',
            'nik' => 'required',
            'nama_user' => 'required',
            'password' => 'required',
            'id_wilayah' => 'exists:wilayahs,id',
            'status' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'wilayah_id' => $request->wilayah_id,
            'nik' => $request->nik,
            'status' => $request->status
        ]);

        return redirect()->route('overseer.index')
                         ->with('success', 'Penanggung Jawab updated successfully.');
    }

    public function destroy(User $users){
        $users->delete();

        return redirect()->route('overseer.index')
            ->with('success', 'PenanggungJawab deleted successfully');    }
}
