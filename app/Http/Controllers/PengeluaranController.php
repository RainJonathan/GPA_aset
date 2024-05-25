<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Overseer;
use App\Models\Pengeluaran;
use App\Models\User;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    //
    public function index()
    {
        $pengeluarans = Pengeluaran::all();
        return view('pengeluaran.index', compact('pengeluarans'));
    }

    public function create(){
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
            $overseers = User::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $overseers = User::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        return view('pengeluaran.create', compact('assets', 'overseers'));
    }


    public function store(Request $request){
        $request->validate([
            'id_aset' => 'exists:rekap_aset,id',
            'pengeluaran' => 'required',
            'keterangan' => 'required',
            'updated_by' => 'required|exists:users,id'
        ]);

        Pengeluaran::create($request->all());

        return redirect()->route('pengeluaran.index')->with('success', 'Pengajuan created successfully.');
    }

    public function show(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.show', compact('pengeluaran'));
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
            $overseers = User::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $overseers = User::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        return view('pengeluaran.edit', compact('pengeluaran', 'assets', 'overseers'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validateData = $request->validate([
            'id_aset' => 'exists:rekap_aset,id',
            'pengeluaran' => 'required',
            'keterangan' => 'required',
            'updated_by' => 'required|exists:users,id'
        ]);

        $pengeluaran->update($validateData);

        return redirect()->route('pengeluaran.index')->with('success', 'Pengajuan updated successfully.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {

        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Pengajuan deleted successfully');
    }
}
