@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tambah Pengajuan Perbaikan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tiket.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_aset">Nama Asset:</label>
                                <select class="form-control" id="id_aset" name="id_aset">
                                    <option value="">Pilih Aset</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" {{ old('id_aset') == $asset->id ? 'selected' : '' }}>
                                            {{ $asset->kode_aset }} - {{$asset->alamat}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan Perbaikan:</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan')}}" placeholder="Apa yang perlu diperbaiki">
                            </div>

                            <div class="form-group">
                                <label for="status">Status Perbaikan:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Pelapor:</label>
                                <select class="form-control" id="user_id" name="user_id">
                                    <option value="">Select Pelapor</option>
                                    @foreach($overseers as $overseer)
                                        <option value="{{ $overseer->id }}">{{ $overseer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="before_photo">Foto Fasilitas yang Rusak</div>
                            <input type="file" class="form-control-file" id="before_photo" name="before_photo[]" accept="image/*" multiple>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('tiket.index') }}'">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
