@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"> Update Pengajuan Pengeluaran Bulanan</h3>
            </div>

            <div class="card-body">
                <form action="{{route('pengeluaran.update', $pengeluaran->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_aset">Nama Asset:</label>
                                <select class="form-control" id="id_aset" name="id_aset">
                                    <option value="">Pilih Aset</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" {{ $pengeluaran->id_aset == $asset->id ? 'selected' : '' }}>
                                            {{ $asset->nama_aset }} - {{ $asset->kode_aset }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan Pengeluaran:</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $pengeluaran->keterangan }}">
                            </div>
                            <div class="form-group">
                                <label for="pengeluaran"> Jumlah Pengeluaran:</label>
                                <input type="text" class="form-control" id="pengeluaran" name="pengeluaran" value="{{ $pengeluaran->pengeluaran }}" >
                            </div>
                            <div class="form-group">
                                <label for="updated_by">Pelapor:</label>
                                <select class="form-control" id="updated_by" name="updated_by">
                                    <option value="">Select Pelapor</option>
                                    @foreach($overseers as $overseer)
                                        <option value="{{ $overseer->id }}" {{ $pengeluaran->updated_by == $overseer->id ? 'selected' : '' }}>{{ $overseer->nama_user }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('pengeluaran.index') }}'">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection