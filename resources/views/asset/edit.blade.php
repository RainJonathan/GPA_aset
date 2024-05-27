@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"> Edit Aset</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('asset.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!--Kiri -->
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="host_id">Penyewa:</label>
                                    <select class="form-control" id="host_id" name="host_id">
                                        <option value="">No Host</option>
                                        @foreach ($hosts as $host)
                                        <option value="{{ $host->id }}" {{ $host->host_id == $host->id ? 'selected' : '' }}> {{ $host->nama_penyewa }} </option> 
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="nama_aset">Nama Aset:</label>
                                    <input type="text" class="form-control" id="nama_aset" name="nama_aset" value="{{ $asset->nama_aset }}" required>
                                </div>
                        
                                <div class="form-group">
                                    <label for="wilayah_id">Wilayah Asset:</label>
                                    <select class="form-control" id="wilayah_id" name="wilayah_id">
                                        <option value="">Select Wilayah</option>
                                        @foreach($wilayahs as $wilayah)
                                            <option value="{{ $wilayah->id }}" {{ (old('wilayah_id') ?? $asset->wilayah_id) == $wilayah->id ? 'selected' : '' }}>{{ $wilayah->nama_wilayah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $asset->alamat }}" required>
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
                                    <label for="status_penyewaan">Status Sewa:</label>
                                    <select class="form-control" id="status_penyewaan" name="status_penyewaan" required>
                                        <option value="">Pilih Status</option>
                                        <option value="1" {{ $asset->status_penyewaan == '1' ? 'selected' : '' }}>Mingguan</option>
                                        <option value="2" {{ $asset->status_penyewaan == '2' ? 'selected' : '' }}>Bulanan</option>
                                        <option value="3" {{ $asset->status_penyewaan == '3' ? 'selected' : '' }}>Tahunan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="no_rumah">No Rumah:</label>
                                    <input type="text" class="form-control" id="no_rumah" name="no_rumah" value="{{ $asset->no_rumah }}">
                                </div>
                                <div class="form-group">
                                    <label for="lantai">Lantai:</label>
                                    <input type="text" class="form-control" id="lantai" name="lantai" value="{{ $asset->lantai }}">
                                </div>
                                <div class="form-group">
                                    <label for="pengeluaran">Pengeluaran:</label>
                                    <input type="number" class="form-control" id="pengeluaran" name="pengeluaran" value="{{ $asset->pengeluaran }}">
                                </div>
                        </div>

                        <!--Kanan -->
                        <div class="col-md-6">
                            @if($asset->photos->count() > 0)
                                <div class="form-group">
                                    <label>Foto Saat Ini:</label> <br>
                                    <div class="row">
                                        @foreach($asset->photos as $photo)
                                            <div class="col-md-7" style="height: 100%; overflow: hidden;">
                                                <img src="{{ asset('foto_aset/' . $photo->photo_path) }}" alt="Asset Photo" class="img-fluid">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                    
                            <div class="form-group">
                                <label for="photos">Ubah Foto?</label>
                                <input type="file" class="form-control-file" id="photos" name="photos[]" multiple>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('asset.edited', $asset->id) }}'">Batal</button>    
                </form>
            </div>
        </div>
    </div>
</section>

@endsection