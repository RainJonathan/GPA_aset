<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Asset;
use App\Models\AssetOwnershipHistory;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {
        $hosts = Host::all();
        return view('host.index', compact('hosts'));
    }

    public function create($asset)
    {
        return view('host.create', compact('asset'));
    }

    public function store(Request $request, $asset)
    {
        $validatedData = $request->validate([
            'nama_penyewa' => 'required',
            'no_ktp' => 'required',
            'no_tlp' => 'required',
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
        $host = Host::create($validatedData);
        $assets = Asset::where('id', $asset)->first();
        $assets->host_id = $host->id;
        $assets->save();

        return redirect()->route('asset.index')
                         ->with('success', 'Host created successfully.');
    }

    public function edit(Host $host)
    {
        return view('host.edit', compact('host'));
    }

    public function update(Request $request, Host $host)
    {
        $validatedData = $request->validate([
            'nama_penyewa' => 'required',
            'no_ktp' => 'required',
            'no_tlp' => 'required',
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
            'total' => 'nullable',
            'saldo_piutang' => 'nullable',
            'status_pengontrak' => '',
            'keterangan'=> '',
            'bulan'=> '',
            'aktif'=> '',
        ]);

        $host->update($validatedData);

        if ($request->has('asset_id')) {
            $assetId = $request->input('asset_id');
            $asset = Asset::with('previousOwners')->find($assetId);
            if ($asset) {
                AssetOwnershipHistory::create([
                    'asset_id' => $assetId,
                    'previous_owner_id' => $host->id,
                ]);
            }
        }

        return redirect()->route('asset.index')
                         ->with('success', 'Host updated successfully');
    }

    public function destroy(Host $host){
        $host->delete();

        return redirect()->route('host.index')
        ->with('success','Asset Deleted Succesfully');
    }
}
