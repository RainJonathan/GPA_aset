@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Penanggung Jawab</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('overseer.update', $overseer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username Baru?:</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $overseer->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK Baru?:</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ $overseer->nik }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru?:</label>
                            <input type="text" class="form-control" id="password" name="password" value="{{ $overseer->password }}" required>
                        </div>
                        <div class="form-group">
                            <label for="id_wilayah">Wilayah?:</label>
                            <select class="form-control" id="id_wilayah" name="id_wilayah">
                                <option value="">Tidak Ada Wilayah</option>
                                @foreach ($wilayahs as $wilayah)
                                    <option value="{{ $wilayah->id }}" {{ $wilayah->id == $overseer->id_wilayah ? 'selected' : '' }}>{{ $wilayah->nama_wilayah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_user">Nama Baru?:</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" value="{{ $overseer->nama_user }}" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status Baru?:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Aktif" {{ $overseer->status == 'Aktif' ? 'selected' : '' }}>Pegawai Aktif</option>
                                <option value="Tidak Aktif" {{ $overseer->status == 'Tidak Aktif' ? 'selected' : '' }}>Pegawai Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('overseer.index') }}'">Batal</button>    

                </form>
            </div>
        </div>
    </div>
</section>

@endsection