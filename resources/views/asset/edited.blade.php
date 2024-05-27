@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Asset</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="col-mt-12">
              <div class="row">
              <!--- Bagian Foto --->
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
                <div class="col-md-8">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Asset Details</h2>
                    <a href="{{ route('asset.edit', $asset) }}" class="btn btn-primary">Edit Aset</a>
                  </div>
                  <table class="table border">
                    <!--- Bagian Utama --->
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
                      <th>Status</th>
                      <td>{{ $asset->tuanRumah ? $asset->tuanRumah->aktif === 0 ? 'Tidak Aktif' : 'Aktif' : '-' }}</td>
                    </tr>
                    <tr>
                      <th>Pengeluaran</th>
                      <td>{{ $asset->pengeluaran ? $asset->pengeluaran : '0'}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!-- Detail Penghuni -->
            <div class="mt-4">
              <h2>Detail Penghuni</h2>
              <table class="table">
                  <thead>
                      <tr>
                          <th>Nama Penyewa</th>
                          <th>No. KTP</th>
                          <th>No. Telepon</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>{{ $asset->tuanRumah ? $asset->tuanRumah->nama_penyewa : '-' }}</td>
                          <td>{{ $asset->tuanRumah ? $asset->tuanRumah->no_ktp : '-' }}</td>
                          <td>{{ $asset->tuanRumah ? $asset->tuanRumah->no_tlp : '-' }}</td>
                      </tr>
                  </tbody>
              </table>
              {{-- @if (!$asset->tuanRumah)
                <div class="mt-4">
                  <a href="{{ route('host.create', $asset->id) }}" class="btn btn-primary">Tambah Penyewa</a>
                </div>
              @endif --}}
              {{-- <button class="btn btn-secondary mt-2" id="edit-tenant-btn">Edit Tenant Info</button> --}}
              @if($asset->host_id)
                  <form action="{{ route('host.edit', $asset->tuanRumah->id) }}" method="GET">
                      <button type="submit" class="btn btn-secondary">Edit Host</button>
                  </form>
              @endif
            </div>
            <!-- Back Button -->
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
    // Get the clicked photo's data-key attribute (index)
    const selectedIndex = clickedPhoto.dataset.key;
  
    // Get references to the main photo and all thumbnails
    const mainPhoto = document.getElementById('mainPhoto');
    const thumbnails = document.querySelectorAll('.thumbnails img');
  
    // Update the main photo source and remove the "selected" class from all thumbnails
    mainPhoto.src = clickedPhoto.src;
    thumbnails.forEach(thumbnail => thumbnail.classList.remove('selected'));
  
    // Add the "selected" class to the clicked thumbnail
    clickedPhoto.classList.add('selected');
  }
</script>


