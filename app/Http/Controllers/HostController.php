<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Asset;
use App\Models\Wilayah;
use App\Models\AssetOwnershipHistory;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {
        if(Auth()->user()->role == 1){
            $hosts = Host::all();
        }else{
            $hosts = Host::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        return view('host.index', compact('hosts'));
    }

    public function create()
    {
        $wilayahs = Wilayah::all();
        return view('host.create', compact('wilayahs'));
    }

    public function store(Request $request, Host $host){
        $validateData = $request->validate([
            'nama_penyewa' => 'required',
            'no_ktp' => 'required',
            'no_tlp' => 'required',
            'wilayah_id' => 'exists:wilayahs,id',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'upah_jasa' => 'required',
            'harga_sewa' => 'required',
            'pendapatan_sewa'=> 'nullable',
            'tanggal_tunai'=> 'nullable',
            'harga_tunai'=>'nullable',
            'tanggal_mandiri'=> 'nullable',
            'harga_mandiri'=> 'nullable',
            'tanggal_bca_leo'=> 'nullable',
            'harga_bca_leo'=> 'nullable',
            'tanggal_bca_sgls'  => 'nullable',
            'harga_bca_sgls'=> 'nullable',
            'saldo_piutang' => 'nullable',
            'status_pengontrak' => '',
            'keterangan'=> '',
            'bulan'=> '',
            'status_aktif'=> '',
        ]);
        $host = Host::create($validateData);
        return redirect()->route('host.index')
                         ->with('success', 'Host created successfully.');
    }

    public function edit(Host $host)
    {
        $wilayahs = Wilayah::all();
        return view('host.edit', compact('host', 'wilayahs'));
    }

    public function update(Request $request, Host $host)
    {
        $validatedData = $request->validate([
            'nama_penyewa' => 'required',
            'no_ktp' => 'required',
            'no_tlp' => 'required',
            'wilayah_id' => 'exists:wilayahs,id',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'upah_jasa' => 'required',
            'harga_sewa' => 'required',
            'pendapatan_sewa'=> 'nullable',
            'tanggal_tunai'=> 'nullable',
            'harga_tunai'=>'nullable',
            'tanggal_mandiri'=> 'nullable',
            'harga_mandiri'=> 'nullable',
            'tanggal_bca_leo'=> 'nullable',
            'harga_bca_leo'=> 'nullable',
            'tanggal_bca_sgls'  => 'nullable',
            'harga_bca_sgls'=> 'nullable',
            'saldo_piutang' => 'nullable',
            'status_pengontrak' => '',
            'keterangan'=> '',
            'bulan'=> '',
            'status_aktif'=> '',
        ]);

        $host->update($validatedData);

        if ($request->has('asset_id')) {
            $assetId = $request->input('asset_id');
            $asset = Asset::find($assetId);
    
            if ($asset && $asset->host_id !== $host->id) {
                AssetOwnershipHistory::create([
                    'asset_id' => $assetId,
                    'previous_owner_id' => $asset->host_id,
                    'ownership_changed_at' => now(),
                ]);
    
                $asset->update(['host_id' => $host->id]);
            }
        }

        return redirect()->route('host.index')
                         ->with('success', 'Host updated successfully');
    }

    public function destroy(Host $host){
        $host->delete();

        return redirect()->route('host.index')
        ->with('success','Asset Deleted Succesfully');
    }
}
