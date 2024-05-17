@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tambah Penanggung Jawab</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('overseer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{old('username')}}">
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK:</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{old('nik')}}">
                            </div>
                            <div class="form-group">
                                <label for="nama_user">Nama Penanggung Jawab:</label>
                                <input type="text" class="form-control" id="nama_user" name="nama_user" value="{{old('nama_user')}}">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="text" class="form-control" id="password" name="password" value="{{old('password')}}">
                            </div>
                            <div class="form-group">
                                <label for="id_wilayah">Wilayah Asset:</label>
                                <select class="form-control" id="id_wilayah" name="id_wilayah">
                                    <option value="">Select Wilayah</option>
                                    @foreach($wilayahs as $wilayah)
                                        <option value="{{ $wilayah->id }}" {{ old('id_wilayah') == $wilayah->id ? 'selected' : '' }}>{{ $wilayah->nama_wilayah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status Kepegawaian:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="Aktif">Pegawai Aktif</option>
                                    <option value="Tidak Aktif">Pegawai Tidak Aktif</option>
                                </select>
                            </div>
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