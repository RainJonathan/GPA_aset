@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tambah Asset</h1>
    <form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="host_id">Nama Penyewa:</label>
            <select class="form-control" id="host_id" name="host_id">
                <option value="">No Host</option>
                @foreach ($hosts as $host)
                    <option value="{{ $host->id }}">{{ $host->nama_penyewa }}</option>
                @endforeach
            </select>
        </div>
        {{-- <div class="form-group">
            <label for="host_id">Penyewa:</label>
            <input type="text" class="form-control" id="host_id" name="host_id">
        </div> --}}
        <div class="form-group">
            <label for="nama_aset">Nama Aset:</label>
            <input type="text" class="form-control" id="nama_aset" name="nama_aset" value="{{ old('nama_aset')}}">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat')}}">
        </div>
        <div class="form-group">
            <label for="lantai">Lantai:</label>
            <input type="text" class="form-control" id="lantai" name="lantai" value="{{ old('lantai')}}">
        </div>
        <div class="form-group">
            <label for="no_rumah">No Rumah:</label>
            <input type="text" class="form-control" id="no_rumah" name="no_rumah" value="{{ old('no_rumah')}}">
        </div>
        <div class="form-group">
            <label for="wilayah">Wilayah:</label>
            <input type="text" class="form-control" id="wilayah" name="wilayah" value="{{ old('wilayah')}}">
        </div>
        <div class="form-group">
            <label for="deskripsi_aset">Deskripsi Aset:</label>
            <input type="text" class="form-control" id="deskripsi_aset" name="deskripsi_aset" value="{{ old('deskripsi_aset')}}">
        </div>
        <div class="form-group">
            <label for="photos">Foto Asset (Maksimal 4 foto):</label>
            <input type="file" class="form-control-file" id="photos" name="photos[]" accept="image/*" multiple>
        </div>
        <div class="form-group">
            <label for="jenis_aset">Jenis Aset:</label>
            <input type="text" class="form-control" id="jenis_aset" name="jenis_aset" value="{{ old('jenis_aset')}}">
        </div>
        <div class="form-group">
            <label for="kode_aset">Kode Aset:</label>
            <input type="text" class="form-control" id="kode_aset" name="kode_aset" value="{{ old('kode_aset')}}">
        </div>
        <div class="form-group">
            <label for="pengeluaran">Pengeluaran Aset:</label>
            <input type="number" class="form-control" id="pengeluaran" name="pengeluaran" value="{{ old('pengeluaran')}}">
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('asset.index') }}'">Batal</button>

    </form>
</div>
@endsection