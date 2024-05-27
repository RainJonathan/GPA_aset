@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pengajuan Pengeluaran Bulanan</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_aset">Nama Asset:</label>
                                    <select class="form-control" id="id_aset" name="id_aset">
                                        <option value="">Pilih Aset</option>
                                        @foreach ($assets as $asset)
                                            <option value="{{ $asset->id }}" {{ old('id_aset') == $asset->id ? 'selected' : '' }}>
                                                {{ $asset->kode_aset }} - {{$asset->alamat}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan Pengeluaran:</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                                        value="{{ old('keterangan') }}" placeholder="Pengeluaran apa yang dilakukan?">
                                </div>
                                <div class="form-group">
                                    <label for="pengeluaran">Jumlah Pengeluaran:</label>
                                    <input type="text" class="form-control" id="pengeluaran" name="pengeluaran"
                                        value="{{ old('pengeluaran') }}" placeholder="Berapa Jumlah Pengeluaran">
                                </div>

                                <div class="form-group">
                                    <label for="updated_by">Pelapor:</label>
                                    <select class="form-control" id="updated_by" name="updated_by">
                                        <option value="">Pilih Pelapor</option>
                                        @foreach ($overseers as $overseer)
                                            <option value="{{ $overseer->id }}">{{ $overseer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-secondary ml-2"
                                            onclick="window.location.href='{{ route('pengeluaran.index') }}'">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

