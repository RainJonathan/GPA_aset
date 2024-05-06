@extends('layouts.app')

@section('content')
<div class="container-fluid mw-100">
    <div class="card">
        <div class="card-body">
            <h1>Para Penyewa</h1>
                {{-- <a href="{{ route('host.create') }}" class="btn btn-success mb-3">Tambah Penyewa</a> --}}
                @if ($hosts->isEmpty())
                <div class="alert alert-info">
                    Tidak ada Penyewa
                </div>
                @else
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto; padding:10px;">
                    <table class="table">
                        <thead class="thead-fixed">
                            <tr>
                                <th>Nama Penyewa</th>
                                <th>No. KTP</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Berakhir</th>
                                <th>Upah Jasa</th>
                                <th>Harga Sewa</th>
                                <th>Status Saldo</th>
                                <th>Status Pengontrak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hosts as $host)
                            <tr>
                                <td>{{ $host->nama_penyewa }}</td>
                                <td>{{ $host->no_ktp }}</td>
                                <td>{{ $host->no_tlp }}</td>
                                <td>{{ $host->tgl_awal }}</td>
                                <td>{{ $host->tgl_akhir }}</td>
                                <td>{{ $host->upah_jasa }}</td>
                                <td>{{ $host->harga_sewa }}</td>
                                <td>{{ $host->saldo_piutang == 0 ? 'Tidak Lunas' : 'Lunas' }}</td>
                                <td>{{ $host->status_pengontrak == 0 ? 'Perorangan' : 'Complimet' }}</td>                
                                <td>
                                    <a href="{{ route('host.edit', $host->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('host.destroy', $host->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

<style>
    /* Fixed table header */
.thead-fixed {
    position: sticky;
    top: -10px;
    background-color: #F5F5F5;
    z-index: 1;
}

</style>
