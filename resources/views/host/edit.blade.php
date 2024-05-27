@extends('layouts.app')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Penyewa</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('host.update', $host->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_penyewa">Nama Penyewa:</label>
                                <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa" value="{{ $host->nama_penyewa }}">
                            </div>
                            <div class="form-group">
                                <label for="no_ktp">No KTP:</label>
                                <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ $host->no_ktp }}">
                            </div>
                            <div class="form-group">
                                <label for="wilayah_id">Wilayah Penyewa:</label>
                                <select class="form-control" id="wilayah_id" name="wilayah_id">
                                    <option value="">Select Wilayah</option>
                                    @foreach($wilayahs as $wilayah)
                                        <option value="{{ $wilayah->id }}" {{ (old('wilayah_id') ?? $host->wilayah_id) == $wilayah->id ? 'selected' : '' }}>{{ $wilayah->nama_wilayah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_tlp">Nomor Telepon:</label>
                                <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{ $host->no_tlp }}">
                            </div>
                            <div class="form-group">
                                <label for="tgl_awal">Tanggal Awal Masuk:</label>
                                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="{{ $host->tgl_awal }}">
                            </div>
                            <div class="form-group">
                                <label for="tgl_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" value="{{ $host->tgl_akhir }}">
                            </div>
                            <div class="form-group">
                                <label for="upah_jasa">Upah Jasa:</label>
                                <input type="text" class="form-control" id="upah_jasa" name="upah_jasa" value="{{ $host->upah_jasa }}" onkeyup="formatInput(this)">
                            </div>
                            <div class="form-group">
                                <label for="harga_sewa">Harga Sewa:</label>
                                <input type="text" class="form-control" id="harga_sewa" name="harga_sewa" value="{{ $host->harga_sewa }}" onkeyup="formatInput(this)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_pembayaran">Bank Pembayaran:</label>
                                <select class="form-control" id="bank_pembayaran" name="bank_pembayaran">
                                    <option value="" disabled selected>Please choose</option>
                                    <option value="0" {{ $host->bank_pembayaran == '0' ? 'selected' : '' }}>BCA</option>
                                    <option value="1" {{ $host->bank_pembayaran == '1' ? 'selected' : '' }}>BRI</option>
                                    <option value="2" {{ $host->bank_pembayaran == '2' ? 'selected' : '' }}>Mandiri</option>
                                    <option value="4" {{ $host->bank_pembayaran == '4' ? 'selected' : '' }}>Tunai</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="harga_bca" id="label_harga_bca">Harga Sewa BCA (SGLS):</label>
                                <input type="text" class="form-control" id="harga_bca" name="harga_bca_sgls" value="{{ $host->harga_bca_sgls }}" onkeyup="formatInput(this)">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_bca" id="label_tanggal_bca">Tanggal Pembayaran BCA (SGLS):</label>
                                <input type="date" class="form-control" id="tanggal_bca" name="tanggal_bca_sgls" value="{{ $host->tanggal_bca_sgls }}">
                            </div>
                
                            <div class="form-group">
                                <label for="harga_bri" id="label_harga_bri">Harga Sewa BCA (LEO):</label>
                                <input type="text" class="form-control" id="harga_bri" name="harga_bca_leo" value="{{ $host->harga_bca_leo }}" onkeyup="formatInput(this)">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_bri" id="label_tanggal_bri">Tanggal Pembayaran BCA (LEO):</label>
                                <input type="date" class="form-control" id="tanggal_bri" name="tanggal_bca_leo" value="{{ $host->tanggal_bca_leo }}">
                            </div>
                
                            <div class="form-group">
                                <label for="harga_mandiri" id="label_harga_mandiri">Harga Sewa Mandiri:</label>
                                <input type="text" class="form-control" id="harga_mandiri" name="harga_mandiri" value="{{ $host->harga_mandiri }}" onkeyup="formatInput(this)">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mandiri" id="label_tanggal_mandiri">Tanggal Pembayaran Mandiri:</label>
                                <input type="date" class="form-control" id="tanggal_mandiri" name="tanggal_mandiri" value="{{ $host->tanggal_mandiri }}">
                            </div>
                
                            <div class="form-group">
                                <label for="harga_tunai" id="label_harga_tunai">Harga Sewa Tunai:</label>
                                <input type="text" class="form-control" id="harga_tunai" name="harga_tunai" value="{{ $host->harga_tunai }}" onkeyup="formatInput(this)">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_tunai" id="label_tanggal_tunai">Tanggal Pembayaran Tunai:</label>
                                <input type="date" class="form-control" id="tanggal_tunai" name="tanggal_tunai" value="{{ $host->tanggal_tunai }}">
                            </div>
                
                            <div class="form-group">
                                <label for="saldo_piutang">Status Saldo Piutang:</label>
                                <select class="form-control" id="saldo_piutang" name="saldo_piutang">
                                    <option value="0" {{ $host->saldo_piutang == '0' ? 'selected' : '' }}>Tidak Lunas</option>
                                    <option value="1" {{ $host->saldo_piutang == '1' ? 'selected' : '' }}>Lunas</option>
                                </select>
                            </div>
                
                            <div class="form-group">
                                <label for="status_pengontrak">Status Pengontrak:</label>
                                <select class="form-control" id="status_pengontrak" name="status_pengontrak">
                                    <option value="0" {{ $host->status_pengontrak == '0' ? 'selected' : '' }}>Perorangan</option>
                                    <option value="1" {{ $host->status_pengontrak == '1' ? 'selected' : '' }}>Complimet</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status_aktif">Status Aktif:</label>
                                <select class="form-control" id="status_aktif" name="status_aktif">
                                    <option value="0" {{ $host->status_aktif == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="1" {{ $host->status_aktif == '1' ? 'selected' : '' }}>Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary ml-2" onclick="window.history.back()">Batal</button>
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

        function updateFieldVisibility() {
            var selectedBank = bankSelect.value;

            labelBca.style.display = selectedBank === "0" ? "block" : "none";
            hargaBca.style.display = selectedBank === "0" ? "block" : "none";
            labelTanggalBca.style.display = selectedBank === "0" ? "block" : "none";
            tanggalBca.style.display = selectedBank === "0" ? "block" : "none";

            labelBri.style.display = selectedBank === "1" ? "block" : "none";
            hargaBri.style.display = selectedBank === "1" ? "block" : "none";
            labelTanggalBri.style.display = selectedBank === "1" ? "block" : "none";
            tanggalBri.style.display = selectedBank === "1" ? "block" : "none";

            labelMandiri.style.display = selectedBank === "2" ? "block" : "none";
            hargaMandiri.style.display = selectedBank === "2" ? "block" : "none";
            labelTanggalMandiri.style.display = selectedBank === "2" ? "block" : "none";
            tanggalMandiri.style.display = selectedBank === "2" ? "block" : "none";

            labelTunai.style.display = selectedBank === "4" ? "block" : "none";
            hargaTunai.style.display = selectedBank === "4" ? "block" : "none";
            labelTanggalTunai.style.display = selectedBank === "4" ? "block" : "none";
            tanggalTunai.style.display = selectedBank === "4" ? "block" : "none";
        }

        bankSelect.addEventListener("change", updateFieldVisibility);
        updateFieldVisibility(); // Call this function initially to set the correct visibility based on the current selected bank
    });
</script>

@endsection
