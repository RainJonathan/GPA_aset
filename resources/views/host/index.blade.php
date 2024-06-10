@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Master Host</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div>
                            <a href="{{ route('host.create') }}" class="btn btn-success mb-3">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Penyewa</span>
                            </a>
                            @if ($hosts->isEmpty())
                                <div class="alert alert-info">
                                    Tidak Ada Penyewa
                                </div>
                            @else
                        </div>
                        <div class="table-responsive" style="overflow-x: auto; overflow-y: auto">
                            <table class="table" id="asset-table">
                                <thead class="thead-fixed">
                                    <tr>
                                        <th>Nama Penyewa</th>
                                        <th>Asset Hunian</th>
                                        <th>No. KTP</th>
                                        <th>No. Telepon</th>
                                        <th>Wilayah Penyewa</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Harga Sewa</th>
                                        <th>Status Saldo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hosts as $host)
                                    <tr>
                                        <td>{{ $host->nama_penyewa }}</td>
                                        <td>{{ optional($host->asset)->nama_aset . ' - ' . optional($host->asset)->kode_aset ?? 'Tidak Ada Aset' }}</td>
                                        <td>{{ $host->no_ktp }}</td>
                                        <td>{{ $host->no_tlp }}</td>
                                        <td>{{ $host->wilayahPenyewa->nama_wilayah}}</td>
                                        <td>{{ $host->tgl_awal }}</td>
                                        <td>{{ $host->tgl_akhir }}</td>
                                        @if ($latestHistory = $host->latestActiveHostAssetHistory)
                                            <td>{{ 'Rp ' . number_format($latestHistory->harga_sewa, 0, ',', '.') }}</td>
                                        @else
                                            <td>N/A</td>
                                        @endif
                                        <td>{{ $host->saldo_piutang == 0 ? 'Tidak Lunas' : 'Lunas' }}</td>
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
        </div>
    </div>
</section>


@endsection