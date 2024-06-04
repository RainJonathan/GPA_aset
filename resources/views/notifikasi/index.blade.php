@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Notifications</h3>
                    </div>
                    <div class="card-body">
                        @if(count($notifications) > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Penyewa</th>
                                        <th>Aset yang Dihuni</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Status Penyewaan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $notification)
                                        <tr>
                                            <td>{{ $notification['nama_penyewa'] }}</td>
                                            <td>
                                                {{ $notification['asset']['nama_aset'] }} <br>
                                                {{ $notification['asset']['kode_aset'] }} <br>
                                                {{ $notification['asset']['alamat'] }}
                                            </td>
                                            <td>{{ $notification['tgl_akhir'] }}</td>
                                            <td>{{ $notification['status_penyewaan'] }}</td>
                                            <td>Masa Sewa Akan Segera Habis.</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Belum ada penyewa yang akan berakhir masa sewanya</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
