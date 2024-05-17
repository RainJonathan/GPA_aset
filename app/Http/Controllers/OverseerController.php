<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Overseer;

class OverseerController extends Controller
{
    public function index(){
        $overseers = Overseer::all();
        return view('overseer.index', compact('overseers'));
    }

    public function create(){
        $wilayahs = Wilayah::all();
        return view('overseer.create', compact('wilayahs'));
    }
    
    public function store(Request $request){
        $request->validate([
            'username' => 'required',
            'nik' => 'required',
            'nama_user' => 'required',
            'password' => 'required',
            'id_wilayah' => 'exists:wilayahs,id',
            'status' => 'required',
        ]);

        Overseer::create($request->all());

        return redirect()->route('overseer.index')
                         ->with('success', 'Penanggung Jawab created successfully.');
    }

    public function edit(Overseer $overseer){
        $wilayahs = Wilayah::all();
        return view('overseer.edit', compact('overseer', 'wilayahs'));
    }

    public function update(Request $request, Overseer $overseer){
        $request->validate([
            'username' => 'required',
            'nik' => 'required',
            'nama_user' => 'required',
            'password' => 'required',
            'id_wilayah' => 'exists:wilayahs,id',
            'status' => 'required'
        ]);

        $overseer->update($request->all());

        return redirect()->route('overseer.index')
                         ->with('success', 'Penanggung Jawab created successfully.');
    }

    public function destroy(Overseer $overseers){
        $overseers->delete();

        return redirect()->route('overseer.index')
            ->with('success', 'PenanggungJawab deleted successfully');    }
}
