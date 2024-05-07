@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Asset</h1>
    <form action="{{ route('asset.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="host_id">Penyewa:</label>
            <select class="form-control" id="host_id" name="host_id">
                <option value="">No Host</option>
                @foreach ($hosts as $host)
                    <option value="{{ $host->id }}" {{ $host->id == $asset->host_id ? 'selected' : '' }}>{{ $host->nama_penyewa }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="nama_aset">Nama Aset:</label>
            <input type="text" class="form-control" id="nama_aset" name="nama_aset" value="{{ $asset->nama_aset }}" required>
        </div>

        <div class="form-group">
            <label for="wilayah">Wilayah:</label>
            <input type="text" class="form-control" id="wilayah" name="wilayah" value="{{ $asset->wilayah }}" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $asset->alamat }}" required>
        </div>
        <div class="form-group">
            <label for="no_rumah">No Rumah:</label>
            <input type="text" class="form-control" id="no_rumah" name="no_rumah" value="{{ $asset->no_rumah }}">
        </div>
        <div class="form-group">
            <label for="lantai">Lantai:</label>
            <input type="text" class="form-control" id="lantai" name="lantai" value="{{ $asset->lantai }}">
        </div>
        
        @if($asset->photos->count() > 0)
            <div class="form-group">
                <label>Foto Saat Ini:</label> <br>
                <div class="row">
                    @foreach($asset->photos as $photo)
                        <div class="col-md-2" style="height: auto; overflow: hidden;">
                            <img src="{{ asset('foto_aset/' . $photo->photo_path) }}" alt="Asset Photo" class="img-fluid" style="height: 100%; width: auto;">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="form-group">
            <label for="photos">Ubah Foto?</label>
            <input type="file" class="form-control-file" id="photos" name="photos[]" multiple>
        </div>

        <div class="form-group">
            <label for="jenis_aset">Jenis Aset:</label>
            <input type="text" class="form-control" id="jenis_aset" name="jenis_aset" value="{{ $asset->jenis_aset }}" required>
        </div>

        <div class="form-group">
            <label for="kode_aset">Kode Aset:</label>
            <input type="text" class="form-control" id="kode_aset" name="kode_aset" value="{{ $asset->kode_aset }}" required>
        </div>
        
        <div class="form-group">
            <label for="pengeluaran">Pengeluaran:</label>
            <input type="number" class="form-control" id="pengeluaran" name="pengeluaran" value="{{ $asset->pengeluaran }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('asset.edited', $asset->id) }}'">Batal</button>

    </form>
</div>
@endsection
