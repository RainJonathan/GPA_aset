@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tambah Wilayah</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('wilayah.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_wilayah">Nama Wilayah:</label>
                                <input type="text" class="form-control" id="nama_wilayah" name="nama_wilayah" value="{{ old('nama_wilayah') }}">
                                @if ($errors->has('nama_wilayah'))
                                    <span class="text-danger">{{ $errors->first('nama_wilayah') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos:</label>
                                <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}">
                                @if ($errors->has('kode_pos'))
                                    <span class="text-danger">{{ $errors->first('kode_pos') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('wilayah.index') }}'">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
