@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"> Tambah Penyewa </h3>
            </div>
            <div class="card-body">
                {{-- <form action="{{ route('host.store', $asset) }}" method="POST"> --}}

                <form action="{{ route('host.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_penyewa">Nama Penyewa:</label>
                                <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa"
                                    value="{{ old('nama_penyewa') }}">
                            </div>
                            <div class="form-group">
                                <label for="no_ktp">No KTP:</label>
                                <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}">
                            </div>
                            <div class="form-group">
                                <label for="wilayah_id">Wilayah Penyewa:</label>
                                <select class="form-control" id="wilayah_id" name="wilayah_id">
                                    <option value="">Select Wilayah</option>
                                    @foreach($wilayahs as $wilayah)
                                        <option value="{{ $wilayah->id }}" {{ old('wilayah_id') == $wilayah->id ? 'selected' : '' }}>{{ $wilayah->nama_wilayah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="asset_id">Aset Yang Ditempati:</label>
                                <select class="form-control" id="asset_id" name="asset_id">
                                    <option value="">Pilih aset yang akan ditempati</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>{{ $asset->kode_aset }} - {{$asset->no_rumah}} - {{$asset->alamat}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_tlp">Nomor Telepon:</label>
                                <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_awal">Tanggal Awal Masuk:</label>
                                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="{{ old('tgl_awal') }}">
                            </div>
                            <div class="form-group">
                                <label for="tgl_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" value="{{ old('tgl_akhir') }}">
                            </div>
                            <div class="form-group">
                                <label for="upah_jasa">Upah Jasa:</label>
                                <input type="text" class="form-control" id="upah_jasa" name="upah_jasa" value="{{ old('upah_jasa') }}"
                                    onkeyup="formatInput(this)">
                            </div>
                            <!-- Add harga_sewa field -->
                            <div class="form-group">
                                <label for="harga_sewa">Harga Sewa:</label>
                                <input type="text" class="form-control" id="harga_sewa" name="harga_sewa" value="{{ old('harga_sewa') }}" required onkeyup="formatInput(this)">
                            </div>                            
                            <div class="form-group">
                                <label for="status_penyewaan">Status Penyewaan:</label>
                                <select class="form-control" id="status_penyewaan" name="status_penyewaan">
                                    <option value="Mingguan" {{ old('status_penyewaan') == 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="Bulanan" {{ old('status_penyewaan') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="Tahunan" {{ old('status_penyewaan') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                                </select>
                            </div>
                        </div>
                            
                            {{-- <div class="form-group">
                                <label for="status_penyewaan">Status Penyewaan:</label>
                                <select class="form-control" id="status_penyewaan" name="status_penyewaan">
                                    @if ($assets->status_penyewaan == 1)
                                        <option value="Mingguan"
                                            {{ old('status_penyewaan') == 'Mingguan' ? 'selected' : '' }}>Mingguan
                                        </option>
                                    @elseif ($assets->status_penyewaan == 2)
                                        <option value="Bulanan"
                                            {{ old('status_penyewaan') == 'Bulanan' ? 'selected' : '' }}>Bulanan
                                        </option>
                                    @elseif ($assets->status_penyewaan == 3)
                                        <option value="Tahunan"
                                            {{ old('status_penyewaan') == 'Tahunan' ? 'selected' : '' }}>Tahunan
                                        </option>
                                    @else
                                        <option value="Mingguan"
                                            {{ old('status_penyewaan') == 'Mingguan' ? 'selected' : '' }}>Mingguan
                                        </option>
                                        <option value="Bulanan"
                                            {{ old('status_penyewaan') == 'Bulanan' ? 'selected' : '' }}>Bulanan
                                        </option>
                                        <option value="Tahunan"
                                            {{ old('status_penyewaan') == 'Tahunan' ? 'selected' : '' }}>Tahunan
                                        </option>
                                    @endif
                                </select>
                            </div> --}}
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary ml-2"
                                    onclick="window.history.back()">Batal</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var bankSelect = document.getElementById("bank_pembayaran");

            var labelBca = document.getElementById("label_harga_bca");
            var hargaBca = document.getElementById("harga_bca");
            var labelTanggalBca = document.getElementById("label_tanggal_bca");
            var tanggalBca = document.getElementById("tanggal_bca");

            var labelBri = document.getElementById("label_harga_bri");
            var hargaBri = document.getElementById("harga_bri");
            var labelTanggalBri = document.getElementById("label_tanggal_bri");
            var tanggalBri = document.getElementById("tanggal_bri");

            var labelMandiri = document.getElementById("label_harga_mandiri");
            var hargaMandiri = document.getElementById("harga_mandiri");
            var labelTanggalMandiri = document.getElementById("label_tanggal_mandiri");
            var tanggalMandiri = document.getElementById("tanggal_mandiri");

            var labelTunai = document.getElementById("label_harga_tunai");
            var hargaTunai = document.getElementById("harga_tunai");
            var labelTanggalTunai = document.getElementById("label_tanggal_tunai");
            var tanggalTunai = document.getElementById("tanggal_tunai");

            // Initially hide the harga_bca input
            labelBca.style.display = "none";
            hargaBca.style.display = "none";
            labelTanggalBca.style.display = "none";
            tanggalBca.style.display = "none";

            labelBri.style.display = "none";
            hargaBri.style.display = "none";
            labelTanggalBri.style.display = "none";
            tanggalBri.style.display = "none";

            labelMandiri.style.display = "none";
            hargaMandiri.style.display = "none";
            labelTanggalMandiri.style.display = "none";
            tanggalMandiri.style.display = "none";

            labelTunai.style.display = "none";
            hargaTunai.style.display = "none";
            labelTanggalTunai.style.display = "none";
            tanggalTunai.style.display = "none";

            bankSelect.addEventListener("change", function() {
                // If BRI is selected (value = 1), show the harga_bca input; otherwise, hide it
                if (bankSelect.value === "0") {
                    labelBca.style.display = "block";
                    hargaBca.style.display = "block";
                    labelTanggalBca.style.display = "block";
                    tanggalBca.style.display = "block";

                    labelBri.style.display = "none";
                    hargaBri.style.display = "none";
                    labelTanggalBri.style.display = "none";
                    tanggalBri.style.display = "none";

                    labelMandiri.style.display = "none";
                    hargaMandiri.style.display = "none";
                    labelTanggalMandiri.style.display = "none";
                    tanggalMandiri.style.display = "none";

                    labelTunai.style.display = "none";
                    hargaTunai.style.display = "none";
                    labelTanggalTunai.style.display = "none";
                    tanggalTunai.style.display = "none";

                } else if (bankSelect.value === "1") {
                    labelBca.style.display = "none";
                    hargaBca.style.display = "none";
                    labelTanggalBca.style.display = "none";
                    tanggalBca.style.display = "none";

                    labelBri.style.display = "block";
                    hargaBri.style.display = "block";
                    labelTanggalBri.style.display = "block";
                    tanggalBri.style.display = "block";

                    labelMandiri.style.display = "none";
                    hargaMandiri.style.display = "none";
                    labelTanggalMandiri.style.display = "none";
                    tanggalMandiri.style.display = "none";

                    labelTunai.style.display = "none";
                    hargaTunai.style.display = "none";
                    labelTanggalTunai.style.display = "none";
                    tanggalTunai.style.display = "none";

                } else if (bankSelect.value === "2") {
                    labelBca.style.display = "none";
                    hargaBca.style.display = "none";
                    labelTanggalBca.style.display = "none";
                    tanggalBca.style.display = "none";

                    labelBri.style.display = "none";
                    hargaBri.style.display = "none";
                    labelTanggalBri.style.display = "none";
                    tanggalBri.style.display = "none";

                    labelMandiri.style.display = "block";
                    hargaMandiri.style.display = "block";
                    labelTanggalMandiri.style.display = "block";
                    tanggalMandiri.style.display = "block";

                    labelTunai.style.display = "none";
                    hargaTunai.style.display = "none";
                    labelTanggalTunai.style.display = "none";
                    tanggalTunai.style.display = "none";

                } else if (bankSelect.value === "4") {
                    labelBca.style.display = "none";
                    hargaBca.style.display = "none";
                    labelTanggalBca.style.display = "none";
                    tanggalBca.style.display = "none";

                    labelBri.style.display = "none";
                    hargaBri.style.display = "none";
                    labelTanggalBri.style.display = "none";
                    tanggalBri.style.display = "none";

                    labelMandiri.style.display = "none";
                    hargaMandiri.style.display = "none";
                    labelTanggalMandiri.style.display = "none";
                    tanggalMandiri.style.display = "none";

                    labelTunai.style.display = "block";
                    hargaTunai.style.display = "block";
                    labelTanggalTunai.style.display = "block";
                    tanggalTunai.style.display = "block";

                } else {
                    labelBca.style.display = "none";
                    hargaBca.style.display = "none";
                    labelTanggalBca.style.display = "none";
                    tanggalBca.style.display = "none";

                    labelBri.style.display = "none";
                    hargaBri.style.display = "none";
                    labelTanggalBri.style.display = "none";
                    tanggalBri.style.display = "none";

                    labelMandiri.style.display = "none";
                    hargaMandiri.style.display = "none";
                    labelTanggalMandiri.style.display = "none";
                    tanggalMandiri.style.display = "none";
                }
            });
        });
    </script>
@endsection
