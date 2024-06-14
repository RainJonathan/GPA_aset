@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Master Penyewa / Tuan Rumah</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div>
                            <a href="{{ route('host.create') }}" class="btn btn-success mb-3">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Penyewa</span>
                            </a>
                            @if ($hosts->isEmpty())
                                <div class="alert alert-info">
                                    Tidak Ada Penyewa
                                </div>
                            @else
                        </div>
                        <div class="table-responsive" style="overflow-x: auto; overflow-y: auto">
                            <table class="table" id="asset-table">
                                <thead class="thead-fixed">
                                    <tr>
                                        <th>Nama Penyewa</th>
                                        <th>Asset Hunian</th>
                                        <th>No. KTP</th>
                                        <th>No. Telepon</th>
                                        <th>Wilayah Penyewa</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Harga Sewa</th>
                                        <th>Status Saldo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hosts as $host)
                                    <tr id="host-row-{{ $host->id }}">
                                        <td>{{ $host->nama_penyewa }}</td>
                                        <td>{{ optional($host->asset)->nama_aset . ' - ' . optional($host->asset)->kode_aset ?? 'Tidak Ada Aset' }}</td>
                                        <td>{{ $host->no_ktp }}</td>
                                        <td id="phone_{{ $host->id }}">{{ $host->no_tlp }}</td>
                                        <td>{{ $host->wilayahPenyewa->nama_wilayah}}</td>
                                        <td>{{ $host->tgl_awal }}</td>
                                        <td>{{ $host->tgl_akhir }}</td>
                                        @if ($latestHistory = $host->latestActiveHostAssetHistory)
                                            <td>{{ 'Rp ' . number_format($latestHistory->harga_sewa, 0, ',', '.') }}</td>
                                        @else
                                            <td>N/A</td>
                                        @endif
                                        <td>{{ $host->saldo_piutang == 0 ? 'Tidak Lunas' : 'Lunas' }}</td>
                                        <td>
                                            <a href="{{ route('host.edit', $host->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm hide-button" data-id="{{ $host->id }}">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Format phone numbers
        $('td[id^="phone_"]').each(function() {
            var phoneNumber = $(this).text().trim();
            var formattedNumber = '+62 ' + phoneNumber.slice(2, 5) + '-' + phoneNumber.slice(5, 9) + '-' + phoneNumber.slice(9);
            $(this).text(formattedNumber);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hideButtons = document.querySelectorAll('.hide-button');

        hideButtons.forEach(button => {
            button.addEventListener('click', function() {
                const hostId = this.getAttribute('data-id');

                if (confirm('Apakah anda yakin ingin menghapus penyewa?')) {
                    fetch(`/hosts/${hostId}/hide`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ _method: 'PUT' })
                    })
                    .then(response => {
                        if (response.ok) {
                            document.getElementById(`host-row-${hostId}`).remove();
                        } else {
                            alert('Failed to hide the host.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while hiding the host.');
                    });
                }
            });
        });
    });
</script>
@endsection
