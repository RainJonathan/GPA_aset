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
                        <table class="table">
                            <tr>
                                <th>Nama Aset</th>
                                <td>{{ $tiket->asset->name }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $tiket->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Before Photos</th>
                                <td class="col-md-2">
                                    @if ($tiket->photo->isNotEmpty())
                                        <img src="{{ asset('before_photos/' . $tiket->photo->first()->before_photo) }}" alt="Before Photo" class="img-fluid main-photo" id="mainPhoto">
                                    @else
                                        <span>No photos available</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>After Photos</th>
                                <td>
                                    @if($tiket->after_photo)
                                        @foreach(json_decode($tiket->after_photo) as $photo)
                                            <img src="{{ asset('after_photos/' . $tiket->photo->first()->after_photo) }}" alt="After Photo" style="max-width: 100px; margin-right: 10px;">
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Penyelesaian</th>
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
                                <td>{{ $tiket->issue_by }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection