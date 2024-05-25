@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Pengeluaran Bulanan Per Asset</h3>
                    </div>

                    <div class="card-body">
                        <div>
                            <a href="{{ route('pengeluaran.create') }}" class="btn btn-success mb-3">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Pengajuan Perbaikan</span>
                            </a>
                            @if ($pengeluarans->isEmpty())
                            <div class="alert alert-info">
                                Tidak ada laporan
                            </div>
                            @else
                        </div>
                        <table class="table" id="asset-table">
                            <thead class="thead-fixed">
                                <tr>
                                    <th>#</th>
                                    <th> Nama Aset </th>
                                    <th> Jumlah Pengeluaran </th>
                                    <th> Keterangan </th>
                                    <th> Dilaporkan oleh </th>
                                    <th> Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengeluarans as $pengeluaran)
                                <tr>
                                    <td>{{$pengeluaran->id}}</td>
                                    <td>{{$pengeluaran->asset->nama_aset}}</td>
                                    <td>{{$pengeluaran->pengeluaran}}</td>
                                    <td>{{$pengeluaran->keterangan}}</td>
                                    <td>{{$pengeluaran->penanggungJawab->nama_user}}</td>
                                    <td>
                                        <a href="{{ route('pengeluaran.edit', $pengeluaran->id) }}" class="btn btn-secondary btn-sm">Update
                                        </a>
                                        {{-- <a href="{{route('pengeluaran.details', $pengeluaran->id)}}" class="btn btn-primary btn-sm">Details
                                        </a> --}}
                                        <form action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
