<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Host;
use App\Models\AssetPhoto;
use App\Models\AssetOwnershipHistory;

use App\Exports\AssetsExport;
use App\Exports\DetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        return view('asset.index', compact('assets'));
    }

    public function create(Request $request)
    {
        $hostId = $request->input('hostId');
        $hosts = Host::all();
        return view('asset.create', compact('hosts', 'hostId'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'host_id' => 'nullable',
            'wilayah' => 'required',
            'nama_aset' => 'required',
            'jenis_aset' => 'required',
            'kode_aset' => 'required',
            'alamat' => 'required',
            'lantai'=> 'nullable',
            'no_rumah' => 'nullable',
            'fasilitas'=> 'nullable',
            'status'=> 'nullable',
            'id_transaksi' => 'exists:tuan_rumah,id',
            'deskripsi_aset' => 'nullable|string',
            'pengeluaran' => 'nullable',
        ]);

        $asset = Asset::create($validatedData);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $timestamp = now()->format('YmdHis');
                $identifier = uniqid();
                $extension = $photo->getClientOriginalExtension();
                $filename = "{$asset->id}_img_{$timestamp}_{$identifier}.{$extension}";
        
                $path = $photo->storeAs('', $filename, 'public');
        
                $assetPhoto = new AssetPhoto();
                $assetPhoto->asset_id = $asset->id;
                $assetPhoto->photo_path = $path;
                $assetPhoto->save();
            }
        }
        return redirect()->route('asset.index')
                         ->with('success', 'Asset created successfully.');
    }

    public function edit(Asset $asset)
    {
        $hosts = Host::all();
        return view('asset.edit', compact('asset', 'hosts'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validatedData = $request->validate([
            'host_id' => '',
            'wilayah' => 'required',
            'nama_aset' => 'required',
            'jenis_aset' => 'required',
            'kode_aset' => 'required',
            'alamat' => 'required',
            'lantai'=> 'nullable',
            'no_rumah' => 'nullable',
            'fasilitas'=> 'nullable',
            'status'=> 'nullable',
            'id_transaksi' => 'exists:tuan_rumah,id',
            'deskripsi_aset' => 'nullable|string',
            'pengeluaran' => 'nullable',
        ]);
        
        if ($asset->host_id !== null) {
            AssetOwnershipHistory::create([
                'asset_id' => $asset->id,
                'previous_owner_id' => $asset->host_id,
                'ownership_changed_at' => now(),
            ]);
        }

        $asset->update($validatedData);
        if ($request->hasFile('photos')) {
            $asset->photos()->delete();
        
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('', 'public');
                
                $assetPhoto = new AssetPhoto();
                $assetPhoto->asset_id = $asset->id;
                $assetPhoto->photo_path = $path;
                $assetPhoto->save();
            }
        }
        return redirect()->route('asset.edited', $asset->id)
                         ->with('success', 'Asset updated successfully');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('asset.index')
                         ->with('success', 'Asset deleted successfully.');
    }
    public function details(Asset $asset)
    {
        return view('asset.details', compact('asset'));
    }

    public function edited(Asset $asset)
    {
        $hosts = Host::all();
        return view('asset.edited', compact('asset', 'hosts'));
    }

    public function earning(){
        $assets = Asset::all();
        return view('asset.earning', compact('assets'));
    }

    public function export(){
        return Excel::download(new AssetsExport, 'assets.xlsx');
    }

    public function exportDetails(){
        return Excel::download(new DetailsExport,'details.xlsx');
    }
}