<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Tiket;
use App\Models\TiketImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TiketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 1) {
            $tickets = Tiket::all();
        } else {
            $tickets = Tiket::whereHas('asset', function($query) use ($user) {
                $query->where('wilayah_id', $user->wilayah_id);
            })->get();
        }
        return view('tiket.index', compact('tickets'));

    }

    public function create()
    {
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
            $overseers = User::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $overseers = User::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }

        return view('tiket.create', compact('assets', 'overseers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_aset' => 'exists:rekap_aset,id',
            'keterangan' => 'required',
            'penyelesaian' => 'nullable',
            'biaya_perbaikan' => 'nullable',
            'status' => 'required',
            'user_id' => 'required|exists:users,id',
            'before_photo' => 'required|array',
            'before_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $tiket = Tiket::create($validatedData);

        if ($request->hasFile('before_photo')) {
            foreach ($request->file('before_photo') as $photo) {
                $timestamp = now()->format('YmdHis');
                $identifier = uniqid();
                $extension = $photo->getClientOriginalExtension();
                $filename = "{$tiket->id}_img_{$timestamp}_{$identifier}.{$extension}";

                $path = $photo->storeAs('', $filename, 'before_photo');

                $tiketPhoto = new TiketImage();
                $tiketPhoto->tiket_id = $tiket->id;
                $tiketPhoto->before_photo = $path;
                $tiketPhoto->save();
            }
        }
        return redirect()->route('tiket.index')->with('success', 'Pengajuan created successfully.');
    }
    private function convertToNumeric($value)
    {
        return empty($value) ? null : floatval(str_replace(',', '', $value));
    }

    public function show(Tiket $tiket)
    {
        return view('tiket.show', compact('tiket'));
    }

    public function edit(Tiket $tiket)
    {
        if(Auth()->user()->role == 1){
            $assets = Asset::all();
            $overseers = User::all();
        }else{
            $assets = Asset::where('wilayah_id',Auth()->user()->wilayah_id)->get();
            $overseers = User::where('wilayah_id',Auth()->user()->wilayah_id)->get();
        }
        return view('tiket.edit', compact('tiket', 'assets', 'overseers'));
    }

    public function update(Request $request, Tiket $tiket)
    {
        $request['biaya_perbaikan'] = $this->convertToNumeric($request['biaya_perbaikan']);

        $validatedData = $request->validate([
            'id_aset' => 'exists:rekap_aset,id',
            'keterangan' => 'required',
            'penyelesaian' => 'nullable',
            'biaya_perbaikan' => 'nullable',
            'status' => 'required',
            'user_id' => 'required|exists:users,id',
            'before_photo' => 'nullable|array',
            'before_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'after_photo' => 'nullable|array',
            'after_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $tiket->update($validatedData);
        $tiketPhoto = new TiketImage();
        if ($request->hasFile('before_photo')) {
            $tiket->photo()->whereNotNull('before_photo')->delete();

            foreach ($request->file('before_photo') as $photo) {
                $timestamp = now()->format('YmdHis');
                $identifier = uniqid();
                $extension = $photo->getClientOriginalExtension();
                $filename = "{$tiket->id}_img_{$timestamp}_{$identifier}.{$extension}";

                $path = $photo->storeAs('', $filename, 'before_photo');

                $tiketPhoto->tiket_id = $tiket->id;
                $tiketPhoto->before_photo = $path;
            }
        }

        if ($request->hasFile('after_photo')) {
            $tiket->photo()->whereNotNull('after_photo')->delete();

            foreach ($request->file('after_photo') as $photo) {
                $timestamp = now()->format('YmdHis');
                $identifier = uniqid();
                $extension = $photo->getClientOriginalExtension();
                $filename = "{$tiket->id}_img_{$timestamp}_{$identifier}.{$extension}";

                $path = $photo->storeAs('', $filename, 'after_photo');

                $tiketPhoto->tiket_id = $tiket->id;
                $tiketPhoto->after_photo = $path;

            }
        }
        $tiketPhoto->save();

        return redirect()->route('tiket.index')->with('success', 'Pengajuan updated successfully.');
    }

    public function destroy(Tiket $tiket)
    {

        $tiket->delete();

        return redirect()->route('tiket.index')
            ->with('success', 'Pengajuan deleted successfully');
    }

    public function details(Tiket $tiket)
    {
        $tiket->load('asset');
        return view('tiket.details', compact('tiket'));
    }
}
