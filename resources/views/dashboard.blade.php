@extends('layouts.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="text-dark">Dashboard</h1>
      </div>
      <!-- Card -->
      <!-- Card Hiijau -->
      <div class="col-lg-3">
        <div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-house-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Aset Dengan Penyewa</span>
            <span class="info-box-number"><h3>{{ $assetsWithHost }}</h3></span>
          </div>
        </div>
      </div>
      <!-- Card Kuning -->
      <div class="col-lg-3">
        <div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-home"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Aset Tanpa Penyewa</span>
            <span class="info-box-number"><h3>{{ $assetsWithoutHost }}</h3></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <!-- Graph bar -->
        <div class="card">
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
          <div class="card-header">
            <h2 class="float-left">Pendapatan per Asset</h2>
            <div class="float-right">
              <a href="{{ route('asset.earning') }}" class="btn btn-primary">Pendapatan Aset</a>
            </div>
          </div>
          <div class="card-body" style="overflow-x: auto; white-space: nowrap;">
            <div class="position-relative mb-4 border">
              <canvas id="sales-chart" height="500"></canvas>
            </div>
            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2">
                <i class="fas fa-square text-primary"> Harga Sewa </i>
              </span>
              <span class="mr-2">
                <i class="fas fa-square text-gray"> Pengeluaran Asset </i>
              </span>
            </div>
          </div>
        </div>
    </div>
      <!-- .end Graph -->

      <!-- Asset Details -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h2 class="float-left">Asset Keseluruhan</h2>
          </div>
          <div class="card-body">
              <table class="table" id="asset-table">
                <thead class="thead-fixed">
                  <tr>
                    <th>#</th>
                    <th>Nama Aset</th>
                    <th>Kode Aset</th>
                    <th>Jenis Aset</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($assets as $asset)
                  <tr class="asset-row" data-set-id="{{ $asset->id}}">
                    <td>{{$asset->id}}</td>
                    <td>{{$asset->nama_aset}}</td>
                    <td>{{$asset->kode_aset}}</td>
                    <td>{{$asset->jenis_aset}}</td>
                    <td>{{$asset->alamat}}</td>
                    <td>
                      <a href="{{ route('asset.details', $asset->id) }}" class="btn btn-primary">Detail</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
  $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true
  console.log({!! json_encode($pengeluaran) !!})
  var $salesChart = $('#sales-chart')
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: {!! json_encode($dataAset) !!},
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: {!! json_encode($hargaSewaWithHost) !!}
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: {!! json_encode($pengeluaran) !!},
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
                    display: true,
                    color: 'rgba(0, 0, 0, .2)',
                    drawBorder: false,
                    zeroLineColor: 'rgba(0, 0, 0, .2)'
                },
          ticks: {
                    beginAtZero: true,
                    stepSize: 500000,
                    callback: function(value, index, values) {
                        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }

    }
  })
})

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


var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
</script>

<style>
  .table-responsive {
    max-height: 500px;
    overflow-y: auto;
}
.thead-fixed {
    position: sticky;
    top: -10px;
    background-color: #F5F5F5;
  }

</style>

@endsection