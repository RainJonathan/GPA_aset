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
            $hosts = Host::with('hostAssetHistories')->where('is_hidden', false)->get();
        } else {
            $hosts = Host::with('hostAssetHistories')
                ->where('wilayah_id', Auth()->user()->wilayah_id)
                ->where('is_hidden', false)
                ->get();
        }

        return view('host.index', compact('hosts'));
    }

    public function create()
    {
        $user = Auth()->user();
        $userWilayahId = $user->wilayah_id;
        $isAdmin = $user->role == 1;

        $occupiedAssetIds = Host::whereNotNull('asset_id')->pluck('asset_id');
        if ($isAdmin) {
            $assets = Asset::whereNotIn('id', $occupiedAssetIds)->get();
            $wilayahs = Wilayah::all();
        } else {
            $assets = Asset::where('wilayah_id', $userWilayahId)
                            ->whereNotIn('id', $occupiedAssetIds)
                            ->get();
            $wilayahs = Wilayah::where('id', $userWilayahId)->get();
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
        $request['harga_sewa'] = $this->convertToNumeric($request['harga_sewa']);
        $request['upah_jasa'] = $this->convertToNumeric($request['upah_jasa']);
        $request['harga_tunai'] = $this->convertToNumeric($request['harga_tunai']);
        $request['harga_mandiri'] = $this->convertToNumeric($request['harga_mandiri']);
        $request['harga_bca_leo'] = $this->convertToNumeric($request['harga_bca_leo']);
        $request['harga_bca_sgls'] = $this->convertToNumeric($request['harga_bca_sgls']);
        $request['pendapatan_sewa'] = $this->convertToNumeric($request['pendapatan_sewa']);
        $request['saldo_piutang'] = $this->convertToNumeric($request['saldo_piutang']);

        $validatedData = $request->validate([
            'asset_id' => 'nullable|integer',
            'nama_penyewa' => 'required|string|max:255',
            'no_ktp' => 'required|string|size:16',
            'no_tlp' => 'required|string|max:20',
            'wilayah_id' => 'required|exists:wilayahs,id',
            'harga_sewa' => 'required|numeric',
            'status_penyewaan' => 'required|string|max:255',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'upah_jasa' => 'required|numeric',
            'tanggal_tunai' => 'nullable|date',
            'harga_tunai' => 'nullable|numeric',
            'tanggal_mandiri' => 'nullable|date',
            'harga_mandiri' => 'nullable|numeric',
            'tanggal_bca_leo' => 'nullable|date',
            'harga_bca_leo' => 'nullable|numeric',
            'tanggal_bca_sgls' => 'nullable|date',
            'harga_bca_sgls' => 'nullable|numeric',
            'saldo_piutang' => 'nullable|numeric',
            'status_pengontrak' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'bulan' => 'nullable|string|max:255',
            'status_aktif' => 'nullable|boolean',
        ]);

        $bankPembayaran = null;
        $hargaPembayaran = null;
        switch ($request->input('bank_pembayaran')) {
            case '0':
                $bankPembayaran = 'BCA Sabar Ganda';
                $hargaPembayaran = $validatedData['harga_bca_sgls'];
                break;
            case '1':
                $bankPembayaran = 'BCA Leo';
                $hargaPembayaran = $validatedData['harga_bca_leo'];
                break;
            case '2':
                $bankPembayaran = 'Mandiri';
                $hargaPembayaran = $validatedData['harga_mandiri'];
                break;
            case '4':
                $bankPembayaran = 'Tunai';
                $hargaPembayaran = $validatedData['harga_tunai'];
                break;
            default:
                break;
        }

        $host = Host::create($validatedData);

        HostAssetHistory::create([
            'host_id' => $host->id,
            'asset_id' => $validatedData['asset_id'],
            'start_date' => $validatedData['tgl_awal'],
            'end_date' => $validatedData['tgl_akhir'],
            'harga_sewa' => $validatedData['harga_sewa'],
            'status_penyewaan' => $validatedData['status_penyewaan'],
            'bank_pembayaran' => $bankPembayaran,
            'harga_pembayaran' => $hargaPembayaran,
        ]);

        return redirect()->route('host.index')->with('success', 'Host created successfully.');
    }

    private function convertToNumeric($value)
    {
        return empty($value) ? null : floatval(str_replace('.', '', $value));
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
        $request['harga_sewa'] = $this->convertToNumeric($request['harga_sewa']);
        $request['upah_jasa'] = $this->convertToNumeric($request['upah_jasa']);
        $request['harga_tunai'] = $this->convertToNumeric($request['harga_tunai']);
        $request['harga_mandiri'] = $this->convertToNumeric($request['harga_mandiri']);
        $request['harga_bca_leo'] = $this->convertToNumeric($request['harga_bca_leo']);
        $request['harga_bca_sgls'] = $this->convertToNumeric($request['harga_bca_sgls']);
        $request['pendapatan_sewa'] = $this->convertToNumeric($request['pendapatan_sewa']);
        $request['saldo_piutang'] = $this->convertToNumeric($request['saldo_piutang']);

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
            'tanggal_tunai' => 'nullable',
            'harga_tunai' => 'nullable',
            'denda_tunai' => 'nullable',
            'tanggal_mandiri' => 'nullable',
            'harga_mandiri' => 'nullable',
            'denda_mandiri' => 'nullable',
            'tanggal_bca_leo' => 'nullable',
            'harga_bca_leo' => 'nullable',
            'denda_bca_leo' => 'nullable',
            'tanggal_bca_sgls' => 'nullable',
            'harga_bca_sgls' => 'nullable',
            'denda_bca_sgls' => 'nullable',
            'saldo_piutang' => 'nullable',
            'status_pengontrak' => '',
            'keterangan' => '',
            'bulan' => '',
            'status_aktif' => '',
        ]);
        $bankPembayaran = null;
        $hargaPembayaran = null;
        switch ($request->input('bank_pembayaran')) {
            case '0':
                $bankPembayaran = 'BCA Sabar Ganda';
                $hargaPembayaran = $validatedData['harga_bca_sgls'];
                break;
            case '1':
                $bankPembayaran = 'BCA Leo';
                $hargaPembayaran = $validatedData['harga_bca_leo'];
                break;
            case '2':
                $bankPembayaran = 'Mandiri';
                $hargaPembayaran = $validatedData['harga_mandiri'];
                break;
            case '4':
                $bankPembayaran = 'Tunai';
                $hargaPembayaran = $validatedData['harga_tunai'];
                break;
            default:
                break;
        }

        $host->update($validatedData);

        HostAssetHistory::create([
            'host_id' => $host->id,
            'asset_id' => $validatedData['asset_id'],
            'start_date' => $validatedData['tgl_awal'],
            'end_date' => $validatedData['tgl_akhir'],
            'harga_sewa' => $validatedData['harga_sewa'],
            'status_penyewaan' => $validatedData['status_penyewaan'],
            'bank_pembayaran' => $bankPembayaran,
            'harga_pembayaran' => $hargaPembayaran,
        ]);

        return redirect()->route('host.index')->with('success', 'Host updated successfully');
    }

    public function destroy(Host $host)
    {
        $host->delete();

        return redirect()->route('host.index')
            ->with('success', 'Asset Deleted Succesfully');
    }
    public function hide($id)
    {
        $host = Host::findOrFail($id);
        $host->is_hidden = true;
        $host->save();

        return response()->json(['success' => true]);
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
                    continue;
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
                    continue;
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
