@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>Manajemen Wilayah</h3>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div>
                                <a href="{{ route('wilayah.create') }}" class="btn btn-success mb-3">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Wilayah Aset</span>
                                </a>
                                @if ($wilayahs->isEmpty())
                                    <div class="alert alert-info">
                                        Tidak Ada Asset
                                    </div>
                                @else
                            </div>
                                <table class="table" id="asset-table">
                                    <thead class="thead-fixed">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Wilayah</th>
                                            <th>Kode Pos</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wilayahs as $wilayah)
                                            <tr>
                                                <td>{{ $wilayah->id }}</td>
                                                <td>{{ $wilayah->nama_wilayah }}</td>
                                                <td>{{ $wilayah->kode_pos }}</td>
                                                <td>
                                                    <a href="{{ route('wilayah.edit', $wilayah->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                                                    <form action="{{ route('wilayah.destroy', $wilayah->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Hapus</button>
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
