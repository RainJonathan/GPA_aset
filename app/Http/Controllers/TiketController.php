<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Tiket;
use App\Models\Overseer;
use App\Models\TiketImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiketController extends Controller
{
    public function index()
    {
        $tickets = Tiket::all();
        return view('tiket.index', compact('tickets'));
    }

    public function create()
    {
        $assets = Asset::all();
        $overseers = Overseer::all();
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
            'issue_by' => 'required|exists:is_user,id',
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

    public function show(Tiket $tiket)
    {
        return view('tiket.show', compact('tiket'));
    }

    public function edit(Tiket $tiket)
    {
        $assets = Asset::all();
        $overseers = Overseer::all();
        return view('tiket.edit', compact('tiket', 'assets', 'overseers'));
    }

    public function update(Request $request, Tiket $tiket)
    {
        $validatedData = $request->validate([
            'id_aset' => 'exists:rekap_aset,id',
            'keterangan' => 'required',
            'penyelesaian' => 'nullable',
            'biaya_perbaikan' => 'nullable',
            'status' => 'required',
            'issue_by' => 'required|exists:is_user,id',
            'before_photo' => 'nullable|array',
            'before_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'after_photo' => 'nullable|array',
            'after_photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $tiket->update($validatedData);

        if ($request->hasFile('before_photo')) {
            // Delete existing before photos
            $tiket->photo()->whereNotNull('before_photo')->delete();
    
            // Save new before photos
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
    
        if ($request->hasFile('after_photo')) {
            // Delete existing after photos
            $tiket->photo()->whereNotNull('after_photo')->delete();
    
            // Save new after photos
            foreach ($request->file('after_photo') as $photo) {
                $timestamp = now()->format('YmdHis');
                $identifier = uniqid();
                $extension = $photo->getClientOriginalExtension();
                $filename = "{$tiket->id}_img_{$timestamp}_{$identifier}.{$extension}";
        
                $path = $photo->storeAs('', $filename, 'after_photo');
        
                $tiketPhoto = new TiketImage();
                $tiketPhoto->tiket_id = $tiket->id;
                $tiketPhoto->after_photo = $path;
                $tiketPhoto->save();
            }
        }

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
