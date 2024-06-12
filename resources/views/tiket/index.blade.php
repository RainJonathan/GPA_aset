@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Halaman Perbaikan Aset</h3>
                    </div>
                    
                    <div class="card-body">
                        <div>
                            <a href="{{ route('tiket.create') }}" class="btn btn-success mb-3">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Pengajuan Perbaikan</span>
                            </a>
                            @if ($tickets->isEmpty())
                                    <div class="alert alert-info">
                                        Tidak ada laporan
                                    </div>
                            @else
                        </div>
                        <table class="table" id="asset-table">
                            <thead class="thead-fixed">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Aset</th>
                                    <th>Kode Aset</th>
                                    <th>Keterangan</th>
                                    <th>Penyelesaian</th>
                                    <th>Biaya Perbaikan</th>
                                    <th>Status Perbaikan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        <td>{{ $ticket->asset->nama_aset }}</td>
                                        <td>{{ $ticket->asset->kode_aset}}</td>
                                        <td>{{ $ticket->keterangan }}</td>
                                        <td>{{ $ticket->penyelesaian }}</td>
                                        <td>{{ $ticket->biaya_perbaikan }}</td>
                                        <td>{{ $ticket->status }}</td>
                                        <td>{{ $ticket->issue_by }}</td>
                                        <td>
                                            <a href="{{ route('tiket.edit', $ticket->id) }}" class="btn btn-success btn-sm">Update
                                            </a>
                                            <a href="{{route('tiket.details', $ticket->id)}}" class="btn btn-primary btn-sm">Details
                                            </a>
                                            <form action="{{ route('tiket.destroy', $ticket->id) }}" method="POST"
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