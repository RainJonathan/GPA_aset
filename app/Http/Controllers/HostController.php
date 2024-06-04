<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Asset;
use App\Models\Wilayah;
use App\Models\HostAssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HostController extends Controller
{
    public function index()
    {
        if (Auth()->user()->role == 1) {
            $hosts = Host::with('hostAssetHistories')->get();
        } else {
            $hosts = Host::with('hostAssetHistories')
                ->where('wilayah_id', Auth()->user()->wilayah_id)
                ->get();
        }

        return view('host.index', compact('hosts'));
    }

    public function create()
    {
        if (Auth()->user()->role == 1) {
            $assets = Asset::all();
            $wilayahs = Wilayah::all();
        } else {
            $assets = Asset::where('wilayah_id', Auth()->user()->wilayah_id)->get();
            $wilayahs = Wilayah::where('id', Auth()->user()->wilayah_id)->get();
        }
        return view('host.create', compact('wilayahs', 'assets'));
    }
    public function createpop(string $asset)
    {
        $asset = Asset::findOrFail($asset);
        return view('host.createpop', compact('asset'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_id' => 'nullable',
            'nama_penyewa' => 'required',
            'no_ktp' => 'required',
            'no_tlp' => 'required',
            'wilayah_id' => 'exists:wilayahs,id',
            'harga_sewa' => 'required',
            'status_penyewaan' => 'required',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'upah_jasa' => 'required',
            'pendapatan_sewa' => 'nullable',
            'tanggal_tunai' => 'nullable',
            'harga_tunai' => 'nullable',
            'tanggal_mandiri' => 'nullable',
            'harga_mandiri' => 'nullable',
            'tanggal_bca_leo' => 'nullable',
            'harga_bca_leo' => 'nullable',
            'tanggal_bca_sgls' => 'nullable',
            'harga_bca_sgls' => 'nullable',
            'saldo_piutang' => 'nullable',
            'status_pengontrak' => '',
            'keterangan' => '',
            'bulan' => '',
            'status_aktif' => '',

        ]);
        $host = Host::create($validatedData);

        Log::info('Host ID:', ['host_id' => $host->id]);
        Log::info('Asset ID:', ['asset_id' => $host->asset_id]);
        Log::info('Start Date:', ['start_date' => $host->tgl_awal]);
        Log::info('End Date:', ['end_date' => $host->tgl_akhir]);
        Log::info('Harga Sewa:', ['harga_sewa' => $host->harga_sewa]);
        Log::info('Status Penyewaan:', ['status_penyewaan' => $host->status_penyewaan]);

        HostAssetHistory::create([
            'host_id' => $host->id,
            'asset_id' => $validatedData['asset_id'],
            'start_date' => $validatedData['tgl_awal'],
            'end_date' => $validatedData['tgl_akhir'],
            'harga_sewa' => $validatedData['harga_sewa'],
            'status_penyewaan' => $validatedData['status_penyewaan'],
        ]);
        return redirect()->route('host.index')->with('success', 'Host created successfully.');
    }

    public function edit(Host $host)
    {
        if (Auth()->user()->role == 1) {
            $assets = Asset::all();
            $wilayahs = Wilayah::all();
        } else {
            $assets = Asset::where('wilayah_id', Auth()->user()->wilayah_id)->get();
            $wilayahs = Wilayah::where('id', Auth()->user()->wilayah_id)->get();
        }

        return view('host.edit', compact('host', 'wilayahs', 'assets'));
    }


    public function update(Request $request, Host $host)
    {
        $validatedData = $request->validate([
            'asset_id' => 'nullable',
            'nama_penyewa' => 'required',
            'no_ktp' => 'required',
            'no_tlp' => 'required',
            'wilayah_id' => 'exists:wilayahs,id',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'upah_jasa' => 'required',
            'harga_sewa' => 'required',
            'status_penyewaan' => 'required',
            'pendapatan_sewa' => 'nullable',
            'tanggal_tunai' => 'nullable',
            'harga_tunai' => 'nullable',
            'tanggal_mandiri' => 'nullable',
            'harga_mandiri' => 'nullable',
            'tanggal_bca_leo' => 'nullable',
            'harga_bca_leo' => 'nullable',
            'tanggal_bca_sgls' => 'nullable',
            'harga_bca_sgls' => 'nullable',
            'saldo_piutang' => 'nullable',
            'status_pengontrak' => '',
            'keterangan' => '',
            'bulan' => '',
            'status_aktif' => '',
        ]);
        $host->update($validatedData);

        HostAssetHistory::create([
            'host_id' => $host->id,
            'asset_id' => $validatedData['asset_id'],
            'start_date' => $validatedData['tgl_awal'],
            'end_date' => $validatedData['tgl_akhir'],
            'harga_sewa' => $validatedData['harga_sewa'],
            'status_penyewaan' => $validatedData['status_penyewaan'],
        ]);

        return redirect()->route('host.index')->with('success', 'Host updated successfully');
    }

    public function destroy(Host $host)
    {
        $host->delete();

        return redirect()->route('host.index')
            ->with('success', 'Asset Deleted Succesfully');
    }
    public function notifikasi()
    {
        $hosts = Host::with('latestActiveHostAssetHistory')->get();
        $notifications = [];
        foreach ($hosts as $host) {
            $history = $host->latestActiveHostAssetHistory;

            if ($history) {
                $notificationDate = null;
                $tglAkhir = Carbon::parse($host->tgl_akhir);

                switch ($history->status_penyewaan) {
                    case 'Mingguan':
                        $notificationDate = $tglAkhir->subDays(3);
                        break;
                    case 'Bulanan':
                        $notificationDate = $tglAkhir->subDays(7);
                        break;
                    case 'Tahunan':
                        $notificationDate = $tglAkhir->subDays(30);
                        break;
                }

                if ($notificationDate && Carbon::now()->greaterThanOrEqualTo($notificationDate)) {
                    $notifications[] = [
                        'nama_penyewa' => $host->nama_penyewa,
                        'tgl_akhir' => $host->tgl_akhir,
                        'status_penyewaan' => $history->status_penyewaan,
                        'asset' => [
                            'nama_aset' => $history->asset->nama_aset,
                            'kode_aset' => $history->asset->kode_aset,
                            'alamat' => $history->asset->alamat,
                        ],
                    ];
                }
            }
        }
        $notificationCount = count($notifications);

        return view('notifikasi.index', compact('notifications', 'notificationCount'));
    }
    public function notifikasiapi()
    {
        $hosts = Host::with('latestActiveHostAssetHistory')->get();
        $notifications = [];
        foreach ($hosts as $host) {
            $history = $host->latestActiveHostAssetHistory;

            if ($history) {
                $notificationDate = null;
                $tglAkhir = Carbon::parse($host->tgl_akhir);

                switch ($history->status_penyewaan) {
                    case 'Mingguan':
                        $notificationDate = $tglAkhir->subDays(3);
                        break;
                    case 'Bulanan':
                        $notificationDate = $tglAkhir->subDays(7);
                        break;
                    case 'Tahunan':
                        $notificationDate = $tglAkhir->subDays(30);
                        break;
                }

                if ($notificationDate && Carbon::now()->greaterThanOrEqualTo($notificationDate)) {
                    $notifications[] = [
                        'nama_penyewa' => $host->nama_penyewa,
                        'tgl_akhir' => $host->tgl_akhir,
                        'status_penyewaan' => $history->status_penyewaan,
                        'asset' => [
                            'nama_aset' => $history->asset->nama_aset,
                            'kode_aset' => $history->asset->kode_aset,
                            'alamat' => $history->asset->alamat,
                        ],
                    ];
                }
            }
        }
        $notificationCount = count($notifications);

        return response()->json(["notifcount" => $notificationCount]);
    }
}
// Exception
// public function create($asset)
// {
//     $wilayahs = Wilayah::all();
//     $assets = Asset::find($asset);
//     return view('host.create', compact('asset', 'wilayahs', 'assets'));
// }
// public function store(Request $request, $asset)
// {
//     $validatedData = $request->validate([
//         'nama_penyewa' => 'required',
//         'no_ktp' => 'required',
//         'no_tlp' => 'required',
//         'wilayah_id' => 'exists:wilayahs,id',
//         'harga_sewa' => 'required',
//         'status_penyewaan' => 'required',
//         'tgl_awal' => 'required',
//         'tgl_akhir' => 'required',
//         'upah_jasa' => 'required',
//         'pendapatan_sewa'=> 'nullable',
//         'tanggal_tunai'=> 'nullable',
//         'harga_tunai'=>'nullable',
//         'tanggal_mandiri'=> 'nullable',
//         'harga_mandiri'=> 'nullable',
//         'tanggal_bca_leo'=> 'nullable',
//         'harga_bca_leo'=> 'nullable',
//         'tanggal_bca_sgls'  => 'nullable',
//         'harga_bca_sgls'=> 'nullable',
//         'saldo_piutang' => 'nullable',
//         'status_pengontrak' => '',
//         'keterangan'=> '',
//         'bulan'=> '',
//         'status_aktif'=> '',

//     ]);
//     $host = Host::create($validatedData);
//     $assets = Asset::where('id', $asset)->first();
//     $assets->host_id = $host->id;
//     $assets->save();

//     AssetOwnershipHistory::create([
//         'asset_id' => $asset,
//         'previous_owner_id' => $host->id,
//         'status_penyewaan' => $request->status_penyewaan,
//         'harga_sewa' => $request->harga_sewa,
//     ]);

//     return redirect()->route('asset.details', $asset)
//                      ->with('success', 'Host created successfully.');
// }
