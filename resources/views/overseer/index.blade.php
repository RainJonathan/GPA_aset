@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Para Penanggung Jawab dan Wilayahnya</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <a href="{{ route('overseer.create') }}" class="btn btn-success mb-3">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Penanggung Jawab</span>
                            </a>
                            @if ($overseers->isEmpty())
                                    <div class="alert alert-info">
                                        Belum ada Penanggung Jawab
                                    </div>
                            @else
                        </div>
                        <table class="table" id="asset-table">
                            <thead class="thead-fixed">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>NIK</th>
                                    <th>Nama Penanggung Jawab</th>
                                    <th>Wilayah Tanggung Jawab</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($overseers as $overseer)
                                    <tr>
                                        <td>{{ $overseer->id }}</td>
                                        <td>{{ $overseer->username }}</td>
                                        <td>{{ $overseer->nik }}</td>
                                        <td>{{ $overseer->nama_user }}</td>
                                        <td>{{ $overseer->wilayahKekuasaan->nama_wilayah }}</td>
                                        <td>{{ $overseer->status }}</td>
                                        <td>
                                            <a href="{{ route('overseer.edit', $overseer->id) }}" class="btn btn-secondary btn-sm">Edit
                                            </a>
                                            <a href="{{route('overseer.details', $overseer->id)}}" class="btn btn-primary btn-sm">Details
                                            </a>
                                            <form action="{{ route('tiket.destroy', $overseer->id) }}" method="POST"
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