@extends('layouts.app')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title"> Rincian Aset</h3>
          </div>

          <div class="card-body">
            <div class="col-mt-12">
              <div class="row">
                <div class="col-md-5">
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
                <div class="col-md-7">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2></h2>
                    <a href="{{ route('asset.edit', $asset) }}" class="btn btn-warning">Edit Aset</a>
                  </div>
                  <table class="table border">
                    <!--- Bagian Rincian Aset --->
                    <tr>
                      <th>Nama Aset</th>
                      <td>{{ $asset->nama_aset }}</td>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <td>{{ $asset->alamat }}</td>
                    </tr>
                    <tr>
                      <th>No Rumah</th>
                      <td>{{ $asset->no_rumah}}</td>
                    </tr>
                    <tr>
                      <th>Lantai Rumah</th>
                      <td>{{ $asset->lantai}}</td>
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
                      <th>Status Sewa</th>
                      <td>{{ $asset->status_penyewaan ? $asset->status_penyewaan : 'Tidak Diketahui' }}</td>
                    </tr>
                    <tr>
                      <th>Status</th>
                      <td>{{ $host ? ($host->status_aktif == 1 ? 'Aktif' : 'Tidak Aktif') : 'Tidak Aktif' }}</td>
                    </tr>
                    <tr>
                      <th>Pengeluaran</th>
                      <td>Rp. {{ number_format($asset->totalPengeluaran(), 0, ',', '.') }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!-- Bagian Penghuni -->
            <div class="mt-4">
              @if($host)
              <h3>Penghuni Aset</h3>
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
                    <td>Rp {{ $host->latestActiveHostAssetHistory->harga_sewa ? number_format($host->latestActiveHostAssetHistory->harga_sewa, 0, ',', '.') : '' }}</td>
                  </tr>
                </tbody>
              </table>
              @else
              <p>Tidak ada penghuni</p>
              @endif
              {{-- @if ($host)
              @else
              <a href="{{ route('host.createpop', $asset) }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i>
                <span>Tambah Penyewa</span>
              </a>
              @endif --}}
              {{-- <button class="btn btn-secondary mt-2" id="edit-tenant-btn">Edit Tenant Info</button> --}}
              @if($asset->host_id)
              <form action="{{ route('host.edit', $asset->tuanRumah->id) }}" method="GET">
                <button type="submit" class="btn btn-secondary">Edit Host</button>
              </form>
              @endif
            </div>
            <a href="{{ route('asset.index')}}" class="btn btn-primary mt-4">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

<script>
  function redirectToEditPage(assetId) {
      window.location.href = `/assets/${assetId}/edit`;
  }
  function changeMainPhoto(clickedPhoto) {
  const selectedIndex = clickedPhoto.dataset.key;
  const mainPhoto = document.getElementById('mainPhoto');
  const thumbnails = document.querySelectorAll('.thumbnails img');

  mainPhoto.src = clickedPhoto.src;
  thumbnails.forEach(thumbnail => thumbnail.classList.remove('selected'));
  clickedPhoto.classList.add('selected');
}
</script>