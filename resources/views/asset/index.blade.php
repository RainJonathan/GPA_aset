@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>Manajemen Asset</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <div>
                                <a href="{{ route('asset.create') }}" class="btn btn-success mb-3">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Asset</span>
                                </a>
                                <a href="{{ route('asset.exportDetails') }}" class="btn btn-primary mb-3">
                                    <i class="fas fa-file-export"></i>
                                    <span>Export ke Excel</span>
                                </a>
                                @if ($assets->isEmpty())
                                    <div class="alert alert-info">
                                        Tidak Ada Asset
                                    </div>
                                @else
                            </div>
                                <table class="table" id="asset-table">
                                    <thead class="thead-fixed">
                                        <tr>
                                            <th>#</th>
                                            <th>Wilayah</th>
                                            <th>Nama Aset</th>
                                            <th>Jenis Aset</th>
                                            <th>Kode Aset</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assets as $asset)
                                            <tr>
                                                <td>{{ $asset->id }}</td>
                                                <td>{{ $asset->assetWilayah->nama_wilayah}}</td>
                                                <td>{{ $asset->nama_aset }}</td>
                                                <td>{{ $asset->jenis_aset }}</td>
                                                <td>{{ $asset->kode_aset }}</td>
                                                <td>{{ $asset->alamat }}</td>
                                                <td>
                                                    <a href="{{ route('asset.edited', $asset->id) }}"
                                                        class="btn btn-secondary btn-sm">Edit</a>
                                                    <form action="{{ route('asset.destroy', $asset->id) }}" method="POST"
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

    <script>
        $(document).ready(function() {
            const table = $('#asset-table').DataTable({
                "order": [
                    [0, "asc"]
                ]
            });
            $('#searchInput').on('input', function() {
                table.search(this.value).draw();
            });
            table.on('draw.dt', function() {
                const info = table.page.info();
                $('#pagination-info').html('Showing page ' + (info.page + 1) + ' of ' + info.pages);
            });
            $('#pagination-container').on('click', '#prev-page', function() {
                table.page('previous').draw('page');
            });

            $('#pagination-container').on('click', '#next-page', function() {
                table.page('next').draw('page');
            });
        });
    </script>

    <style>
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .thead-fixed {
            position: sticky;
            top: -10px;
            background-color: #F5F5F5;
        }
    </style>
@endsection
