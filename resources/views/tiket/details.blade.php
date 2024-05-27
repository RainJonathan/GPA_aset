@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Details Pengajuan Perbaikan
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="col-md-12" style="justify-content: center">
                            <table class="table">
                                <tr>
                                    <th>Nama Aset</th>
                                    <td>{{ $tiket->asset->nama_aset }} - {{$tiket->asset->alamat}}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan Perbaikan</th>
                                    <td>{{ $tiket->keterangan }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 10%">Foto Sebelum Perbaikan</th>
                                    <td class="col-md-2">
                                        @if ($tiket->photo->isNotEmpty())
                                            @foreach ($tiket->photo as $photo)
                                                <img src="{{ asset('before_photos/' . $photo->before_photo) }}" alt="Before Photo" class="img-fluid main-photo" style="max-width: 100px; height: auto; margin: 0 5px 5px 0;">
                                            @endforeach
                                        @else
                                            <span>No photos available</span>
                                        @endif
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>Foto Setelah Perbaikan</th>
                                    <td class="col-md-2">
                                        @if($tiket->photo->isNotEmpty())
                                            @foreach($tiket->photo as $photo)
                                                @if ($photo->after_photo != null)
                                                    <img src="{{ asset('after_photos/' . $photo->after_photo) }}" alt="After Photo" style="margin-right: 10px; max-width: 100px; height: auto;">
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Perbaikan</th>
                                    <td>{{ $tiket->penyelesaian }}</td>
                                </tr>
                                <tr>
                                    <th>Biaya Perbaikan</th>
                                    <td>{{ $tiket->biaya_perbaikan }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $tiket->status }}</td>
                                </tr>
                                <tr>
                                    <th>Issue By</th>
                                    <td>{{ $tiket->penanggungJawab->name }}</td>
                                </tr>
    
                            </table>
                        </div>
                        <a href="{{ route('tiket.index') }}" class="btn btn-secondary mt-4">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
