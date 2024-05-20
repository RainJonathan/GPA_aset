@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Penanggung Jawab</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('overseer.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Baru?:</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK Baru?:</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ $user->nik }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Baru?:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru?:</label>
                            <input type="text" class="form-control" id="password" name="password" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="wilayah_id">Wilayah?:</label>
                            <select class="form-control" id="wilayah_id" name="wilayah_id">
                                <option value="">Tidak Ada Wilayah</option>
                                @foreach ($wilayahs as $wilayah)
                                    <option value="{{ $wilayah->id }}" {{ $wilayah->id == $user->wilayah_id ? 'selected' : '' }}>{{ $wilayah->nama_wilayah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status Baru?:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Aktif" {{ $user->status == 'Aktif' ? 'selected' : '' }}>Pegawai Aktif</option>
                                <option value="Tidak Aktif" {{ $user->status == 'Tidak Aktif' ? 'selected' : '' }}>Pegawai Tidak Aktif</option>
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
