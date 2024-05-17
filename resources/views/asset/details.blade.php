@extends('layouts.app')

@section('content')
<div class="content-header">
  <h1>Detail Aset</h1>
</div>

<section class="content">
  <div class="container">
    <div class="card">
      <div class="card-body border">
        <div class="col-mt-12">
          <div class="row">

            <!-- Foto -->
            <!-- Foto Besar -->
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  @if ($asset->photos->isNotEmpty())
                    <img src="{{ asset('foto_aset/' . $asset->photos->first()->photo_path) }}" alt="Asset Photo" class="img-fluid main-photo" id="mainPhoto">
                  @else
                    <span>No photos available</span>
                  @endif
                </div>
              </div>
              <!-- Foto Kecil -->
              <div class="row thumbnail">
                @forelse($asset->photos as $key => $photo)
                <div class="col-md-3 grid-item">
                  <img src="{{ asset('foto_aset/' . $photo->photo_path) }}" alt="Asset Photo" class="img-fluid thumbnail" data-key="{{ $key }}" onclick="changeMainPhoto(this)">
                </div>
                @empty
                @endforelse
              </div>
            </div>

            <!-- Bagian Detail -->
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
                  <td>{{ $asset->assetWilayah ? $asset->assetWilayah->nama_wilayah : 'N/A' }}</td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>{{ $asset->tuanRumah ? $asset->tuanRumah->aktif === 0 ? 'Tidak Aktif' : 'Aktif' : '-' }}</td>
                </tr>
                <tr>
                  <th>Pengeluaran</th>
                  <td>Rp. {{ number_format($asset->pengeluaran, 0, ',', '.') }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <!-- Bagian Penghuni Sekarang -->
        <div class="col-mt-12">
          <div class="col-mt-4">
            <h3>Penghuni Sekarang</h3>
          </div>
          <table class="table border">
            <thead>
              <tr>
                <th>Nama Penyewa</th>
                <th>No. KTP</th>
                <th>No. Telepon</th>
                <th>Harga Sewa</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $asset->tuanRumah ? $asset->tuanRumah->nama_penyewa : '-' }}</td>
                <td>{{ $asset->tuanRumah ? $asset->tuanRumah->no_ktp : '-' }}</td>
                <td>{{ $asset->tuanRumah ? $asset->tuanRumah->no_tlp : '-' }}</td>
                <td>{{ $asset->tuanRumah ? 'Rp. ' . number_format($asset->tuanRumah->harga_sewa, 2, ',', '.') : '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Bagian Penghuni Sebelumnya -->
        <div class="col-mt-12">
          <div class="mt-4">
            @if ($asset->previousOwners->count())
            <h3>Penghuni Sebelumnya</h3>
            <div class="scrollable-box">
              <table class="table border">
                <thead class="sticky-header">
                  <tr>
                    <th>Nama Penyewa</th>
                    <th>No. KTP</th>
                    <th>No. Telepon</th>
                    <th>Upah Jasa</th>
                    <th>Harga Sewa</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Total Pendapatan Sewa</th>
                    <th>Status Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($asset->previousOwners as $previousOwner)
                  <tr>
                    <td>{{ $previousOwner->nama_penyewa }}</td>
                    <td>{{ $previousOwner->no_ktp }}</td>
                    <td>{{ $previousOwner->no_tlp }}</td>
                    <td>{{ $previousOwner->upah_jasa }}</td>
                    <td>Rp {{ number_format($previousOwner->harga_sewa, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $previousOwner->tgl_awal)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $previousOwner->tgl_akhir)->format('d-m-Y') }}</td>     
                    <td>Rp {{ number_format($previousOwner->upah_jasa + $previousOwner->harga_sewa, 0, ',', '.') }}</td>
                    <td>{{ $previousOwner->saldo_piutang == 0 ? 'Tidak Lunas' : 'Lunas' }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @endif
            {{-- @if (!$asset->tuanRumah)
              <div class="mt-4">
                <a href="{{ route('host.create', $asset->id) }}" class="btn btn-primary">Tambah Penyewa</a>
              </div>
            @endif --}}
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-4">Back</a>
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
    width: 300px;
    height: 200px;
    object-fit: cover;
  }
</style>
@endsection