@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tambah Asset</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="host_id">Nama Penyewa:</label>
                                <select class="form-control" id="host_id" name="host_id">
                                    <option value="">No Host</option>
                                    @foreach ($hosts as $host)
                                    <option value="{{ $host->id }}" {{ old('host_id') == $host->id ? 'selected' : '' }}> {{ $host->nama_penyewa }} </option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_aset">Nama Aset:</label>
                                <input type="text" class="form-control" id="nama_aset" name="nama_aset" value="{{ old('nama_aset')}}">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat:</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat')}}">
                            </div>
                            <div class="form-group">
                                <label for="wilayah_id">Wilayah Asset:</label>
                                <select class="form-control" id="wilayah_id" name="wilayah_id">
                                    <option value="">Select Wilayah</option>
                                    @foreach($wilayahs as $wilayah)
                                        <option value="{{ $wilayah->id }}" {{ old('wilayah_id') == $wilayah->id ? 'selected' : '' }}>{{ $wilayah->nama_wilayah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_aset">Jenis Aset:</label>
                                <input type="text" class="form-control" id="jenis_aset" name="jenis_aset" value="{{ old('jenis_aset')}}">
                            </div>
                            <div class="form-group">
                                <label for="photos">Foto Asset (Maksimal 4 foto):</label>
                                <input type="file" class="form-control-file" id="photos" name="photos[]" accept="image/*" multiple>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_rumah">No Rumah:</label>
                                <input type="text" class="form-control" id="no_rumah" name="no_rumah" value="{{ old('no_rumah')}}">
                            </div>
                            <div class="form-group">
                                <label for="lantai">Lantai:</label>
                                <input type="text" class="form-control" id="lantai" name="lantai" value="{{ old('lantai')}}">
                            </div>
                            <div class="form-group">
                                <label for="fasilitas">Fasilitas:</label>
                                <input type="text" class="form-control" id="fasilitas" name="fasilitas" value="{{ old('fasilitas')}}">
                            </div>
                            <div class="form-group">
                                <label for="deskripsi_aset">Deskripsi Aset:</label>
                                <input type="text" class="form-control" id="deskripsi_aset" name="deskripsi_aset" value="{{ old('deskripsi_aset')}}">
                            </div>
                            <div class="form-group">
                                <label for="kode_aset">Kode Aset:</label>
                                <input type="text" class="form-control" id="kode_aset" name="kode_aset" value="{{ old('kode_aset')}}">
                            </div>
                            <div class="form-group">
                                <label for="status_penyewaan">Status Sewa:</label>
                                <select class="form-control" id="status_penyewaan" name="status_penyewaan" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1" {{ old('status_penyewaan') == '1' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="2" {{ old('status_penyewaan') == '2' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="3" {{ old('status_penyewaan') == '3' ? 'selected' : '' }}>Tahunan</option>
                                </select>
                            </div>
                        </div>
                    <div>
                </form>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('asset.index') }}'">Batal</button>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection