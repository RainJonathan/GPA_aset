@extends('layouts.app')

@section('content')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Detail Pendapatan per Aset</h3>
          </div>

          <div class="card-body">
            <a href="{{ route('asset.export') }}" class="btn btn-success">Export to Excel</a>
            <table class="table border" id="asset-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Aset</th>
                  <th>Alamat Aset</th>
                  <th>Kode Aset</th>
                  <th>Pendapatan</th>
                  <th>Pengeluaran</th>
                </tr>
              </thead>
              <tbody>
                @foreach($assets as $index=>$asset)
                  <tr class="asset-row" data-set-id="{{ $asset->id }}">
                    <td>{{ $index+1}}</td>
                    <td>{{ $asset->nama_aset }}</td>
                    <td>{{ $asset->alamat }}</td>
                    <td>{{ $asset->kode_aset}}</td>
                    <td>{{ $asset->tuanRumah ? number_format($asset->tuanRumah->harga_sewa, 2, ',', '.') : '-' }}</td>
                    <td>{{ $asset->pengeluaran ? number_format($asset->pengeluaran, 2, ',', '.') : '-' }}</td>
                  </tr>
              @endforeach
              </tbody>
            </table>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-4">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
    const table = $('#asset-table').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#searchInput').on('input', function () {
        table.search(this.value).draw();
    });
    table.on('draw.dt', function () {
        const info = table.page.info();
        $('#pagination-info').html('Showing page ' + (info.page + 1) + ' of ' + info.pages);
    });
    $('#pagination-container').on('click', '#prev-page', function () {
        table.page('previous').draw('page');
    });

    $('#pagination-container').on('click', '#next-page', function () {
        table.page('next').draw('page');
    });
});
</script>

<style>
.table-responsive {
  max-height: 400px;
  overflow-y: auto;
}
.thead-fixed {
  position: sticky;
  top: -10px;
  background-color: #F5F5F5;
}
</style>

@endsection
