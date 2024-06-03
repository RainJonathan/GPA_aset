@extends('layouts.app')

@section('content')
    <section>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Keterangan Aset</h3>
                            </div>

                            <div class="card-body">
                                <div class="col-mt-12">
                                    <div class="row">
                                        <!-- Foto -->
                                        <!-- Foto Besar -->
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if ($asset->photos->isNotEmpty())
                                                        <img src="{{ asset('foto_aset/' . $asset->photos->first()->photo_path) }}"
                                                            alt="Asset Photo" class="img-fluid main-photo" id="mainPhoto">
                                                    @else
                                                        <span>Tidak Ada Foto Aset</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Foto Kecil -->
                                            <div class="row thumbnail">
                                                @forelse($asset->photos as $key => $photo)
                                                    <div class="col-md-3 grid-item">
                                                        <img src="{{ asset('foto_aset/' . $photo->photo_path) }}"
                                                            alt="Asset Photo" class="img-fluid thumbnail"
                                                            data-key="{{ $key }}" onclick="changeMainPhoto(this)">
                                                    </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <table class="table border">
                                                <tr>
                                                    <th>Nama Aset</th>
                                                    <td>{{ $asset->nama_aset }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>{{ $asset->alamat }}</td>
                                                </tr>
                                                <tr>
                                                    <th>No. Rumah</th>
                                                    <td>{{ $asset->no_rumah }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Aset</th>
                                                    <td>{{ $asset->jenis_aset }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Wilayah Aset</th>
                                                    <td>{{ $asset->assetWilayah ? $asset->assetWilayah->nama_wilayah : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status Sewa</th>
                                                    <td>
                                                        @if ($asset->status_penyewaan == 1)
                                                            Mingguan
                                                        @elseif ($asset->status_penyewaan == 2)
                                                            Bulanan
                                                        @elseif ($asset->status_penyewaan == 3)
                                                            Tahunan
                                                        @else
                                                            Tidak diketahui
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Pengeluaran</th>
                                                    <td>Rp {{ number_format($asset->totalPengeluaran(), 0, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- Penghuni sekarang -->
                                <div class="col-md-12">
                                    <h3>Penghuni Sekarang</h3>
                                    @if ($host)
                                        <table class="table">
                                            <thead class="sticky-header">
                                                <tr>
                                                    <th> Nama Penyewa </th>
                                                    <th> No Telepon </th>
                                                    <th> NIK </th>
                                                    <th> Tanggal Masuk </th>
                                                    <th> Tangggal Keluar </th>
                                                    <th> Harga Sewa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $host->nama_penyewa }}</td>
                                                    <td>{{ $host->no_tlp }}</td>
                                                    <td>{{ $host->no_ktp }}</td>
                                                    <td>{{ $host->tgl_awal }}</td>
                                                    <td>{{ $host->tgl_akhir }}</td>
                                                    <td>Rp
                                                        {{ $host->latestActiveHostAssetHistory->harga_sewa ? number_format($host->latestActiveHostAssetHistory->harga_sewa, 0, ',', '.') : '' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <p>Tidak ada penghuni saat ini.</p>
                                    @endif
                                </div>
                                <hr>
                                <!-- Penghuni sebelumnya -->
                                <div class="col-md-12">
                                    <h3>Penghuni Sebelumnya</h3>
                                    <div class="scrollable-box">
                                        <table class="table table-bordered">
                                            <thead class="sticky-header">
                                                <tr>
                                                    <th>Nama Penyewa</th>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Tanggal Keluar</th>
                                                    <th>Harga Sewa</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($asset->hostAssetHistories as $history)
                                                    <tr>
                                                        <td>{{ $history->host->nama_penyewa }}</td>
                                                        <td>{{ $history->start_date }}</td>
                                                        <td>{{ $history->end_date }}</td>
                                                        <td>{{ $history->harga_sewa ? 'Rp ' . number_format($history->harga_sewa, 0, ',', '.') : '-' }}
                                                        </td>
                                                        <td>{{ $history->status_penyewaan }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @if ($host)
                                        {

                                        }
                                    @else
                                        <a href="{{ route('host.createpop', $asset) }}" class="btn btn-success mb-3">
                                            <i class="fas fa-plus"></i>
                                            <span>Tambah Penyewa</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function changeMainPhoto(clickedPhoto) {
            const selectedIndex = clickedPhoto.dataset.key;
            const mainPhoto = document.getElementById('mainPhoto');
            const thumbnails = document.querySelectorAll('.thumbnails img');

            mainPhoto.src = clickedPhoto.src;
            thumbnails.forEach(thumbnail => thumbnail.classList.remove('selected'));

            clickedPhoto.classList.add('selected');
        }
    </script>
    <style>
        .scrollable-box {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 20px
        }

        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #F5F5F5;
            z-index: 1;
        }

        #mainPhoto {
            width: 400px;
            height: 300px;
            object-fit: cover;
        }
    </style>
@endsection
