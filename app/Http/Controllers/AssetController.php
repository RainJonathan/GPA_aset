<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Host;
use App\Models\Wilayah;
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
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        return view('asset.index', compact('assets'));
    }

    public function create(Request $request)
    {
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
            $hosts = Host::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $hosts = Host::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        $hostId = $request->input('hostId');
        $wilayahs = Wilayah::all();
        return view('asset.create', compact('hosts', 'hostId', 'wilayahs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'host_id' => 'nullable',
            'wilayah_id' => 'exists:wilayahs,id',
            'nama_aset' => 'required',
            'jenis_aset' => 'required',
            'kode_aset' => 'required',
            'status_penyewaan' => 'nullable',
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
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
            $hosts = Host::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $hosts = Host::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        $wilayahs = Wilayah::all();
        return view('asset.edit', compact('asset', 'hosts', 'wilayahs'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validatedData = $request->validate([
            'host_id' => '',
            'wilayah_id' => 'exists:wilayahs,id',
            'nama_aset' => 'required',
            'jenis_aset' => 'required',
            'kode_aset' => 'required',
            'status_penyewaan' => 'nullable',
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
        $asset->load('assetWilayah');
        return view('asset.details', compact('asset'));
    }

    public function edited(Asset $asset)
    {
        $hosts = Host::all();
        return view('asset.edited', compact('asset', 'hosts'));
    }

    public function earning(){
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        return view('asset.earning', compact('assets'));
    }

    public function export(){
        return Excel::download(new AssetsExport, 'assets.xlsx');
    }

    public function exportDetails(){
        return Excel::download(new DetailsExport,'details.xlsx');
    }
}
