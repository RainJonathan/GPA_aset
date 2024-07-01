<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Host;
use App\Models\Wilayah;
use App\Models\AssetPhoto;
use App\Models\HostAssetHistory;

use App\Exports\AssetsExport;
use App\Exports\DetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            $wilayahs = Wilayah::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $hosts = Host::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $wilayahs = Wilayah::where('id',Auth()->user()->wilayah_id)->get();
        }
        $hostId = $request->input('hostId');
        return view('asset.create', compact('hosts', 'hostId', 'wilayahs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
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

        //Untuk History
        if ($request->filled('host_id')) {
            HostAssetHistory::create([
                'host_id' => $request->host_id,
                'asset_id' => $asset->id,
                'start_date' => now(),
                'end_date' => null,
                'harga_sewa' => $request->harga_sewa,
                'status_penyewaan' => $request->status_penyewaan,
            ]);
        }

        //Untuk Photo
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

        $asset->update($validatedData);

        //Untuk History
        if ($request->filled('host_id')) {
            HostAssetHistory::create([
                'host_id' => $request->host_id,
                'asset_id' => $asset->id,
                'start_date' => $asset->updated_at, // assuming this is the update date
                'end_date' => null,
                'harga_sewa' => $request->harga_sewa,
                'status_penyewaan' => $request->status_penyewaan,
            ]);
        }

        //Untuk Foto
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
        $asset->load(['assetWilayah', 'tickets', 'pengeluaran']);
        $host = Host::where('asset_id', $asset->id)->first();

        return view('asset.details', compact('asset', 'host'));
    }

    public function edited(Asset $asset)
    {
        $asset->load(['assetWilayah', 'tickets', 'pengeluaran']);
        $host = Host::where('asset_id', $asset->id)->first();
        return view('asset.edited', compact('asset', 'host'));
    }

    public function earning()
    {
        if(Auth()->user()->role == 1){
            $assets = Asset::with(['tickets', 'pengeluaran', 'hostAssetHistories' => function($query) {
                $query->latest();
            }])->get();
        } else {
            $assets = Asset::where('wilayah_id', Auth()->user()->wilayah_id)
                ->with(['tickets', 'pengeluaran', 'hostAssetHistories' => function($query) {
                    $query->latest();
                }])
                ->get();
        }
        foreach ($assets as $asset) {
            $asset->totalPendapatan = $asset->hostAssetHistories()
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('harga_sewa');
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
