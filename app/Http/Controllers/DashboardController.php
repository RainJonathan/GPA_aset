<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        $assets = Asset::all();

        $dataAset = Asset::pluck('kode_aset');
        $assetsWithHost = Asset::has('tuanRumah')->count();
        $assetsWithoutHost = Asset::doesntHave('tuanRumah')->count();
        $hargaSewaWithHost = $assets->map(function($asset) {
            return $asset->tuanRumah ? $asset->tuanRumah->harga_sewa : 0;
        });

        $pengeluaran = $assets->pluck('pengeluaran')->toArray();


        return view("dashboard", compact('assets', 'assetsWithHost', 'assetsWithoutHost', 'dataAset', 'hargaSewaWithHost', 'pengeluaran'));
    }
}
