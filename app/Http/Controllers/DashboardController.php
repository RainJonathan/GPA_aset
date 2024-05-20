<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
            $dataAset = Asset::pluck('kode_aset');
            $assetsWithHost = Asset::has('tuanRumah')->count();
            $assetsWithoutHost = Asset::doesntHave('tuanRumah')->count();
            $hargaSewaWithHost = $assets->map(function($asset) {
                return $asset->tuanRumah ? $asset->tuanRumah->harga_sewa : 0;
            });

            $pengeluaran = $assets->pluck('pengeluaran')->toArray();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $dataAset = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->pluck('kode_aset');
            $assetsWithHost = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->has('tuanRumah')->count();
            $assetsWithoutHost = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->doesntHave('tuanRumah')->count();
            $hargaSewaWithHost = $assets->where('wilayah_id',Auth()->user()->wilayah_id)->map(function($asset) {
                return $asset->tuanRumah ? $asset->tuanRumah->harga_sewa : 0;
            });

            $pengeluaran = $assets->where('wilayah_id',Auth()->user()->wilayah_id)->pluck('pengeluaran')->toArray();
        }



        return view("dashboard", compact('assets', 'assetsWithHost', 'assetsWithoutHost', 'dataAset', 'hargaSewaWithHost', 'pengeluaran'));
    }
}
