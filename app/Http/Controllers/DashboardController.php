<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Host;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth()->user()->role == 1) {
            $assets = Asset::all();
            $dataAset = Asset::pluck('kode_aset');
            $assetsWithHost = Host::whereNotNull('asset_id')->distinct('asset_id')->count('asset_id');
            $assetsWithoutHost = Asset::count() - $assetsWithHost;
            $hargaSewaWithHost = $assets->map(function ($asset) {
                $latestHistory = $asset->hostAssetHistoriesMonthYear->first();
                return $latestHistory ? $latestHistory->harga_sewa : 0;
            });

            $pengeluaran = $assets->map(function ($asset) {
                return $asset->totalPengeluaran();
            });
        } else {
            $assets = Asset::where('wilayah_id', Auth()->user()->wilayah_id)->get();
            $dataAset = $assets->pluck('kode_aset');
            $assetsWithHost = Host::where('wilayah_id', Auth()->user()->wilayah_id)
                ->whereNotNull('asset_id')
                ->distinct('asset_id')
                ->count('asset_id');
            $assetsWithoutHost = $assets->count() - $assetsWithHost;
            $hargaSewaWithHost = $assets->map(function ($asset) {
                $latestHistory = $asset->hostAssetHistoriesMonthYear->latest('id')->first();
                return $latestHistory ? $latestHistory->harga_sewa : 0;
            });

            $pengeluaran = $assets->map(function ($asset) {
                return $asset->totalPengeluaran();
            });
        }

        return view('dashboard', compact('assets', 'dataAset', 'assetsWithHost', 'assetsWithoutHost', 'hargaSewaWithHost', 'pengeluaran'));
    }

}
