@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Tambah Penyewa</h1>
        <form action="{{ route('host.store', $asset) }}" method="POST">
            @csrf
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
                <label for="no_tlp">Nomor Telepon:</label>
                <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}">
            </div>
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
            <div class="form-group">
                <label for="harga_sewa">Harga Sewa:</label>
                <input type="text" class="form-control" id="harga_sewa" name="harga_sewa" value="{{ old('upah_jasa') }}"
                    onkeyup="formatInput(this)">
            </div>
            <div class="form-group">
                <label for="bank_pembayaran">Bank Pembayaran:</label>
                <select class="form-control" id="bank_pembayaran" name="bank_pembayaran">
                    <option value="" disabled selected>Please choose</option>
                    <option value="0" {{ old('status_pengontrak') == '0' ? 'selected' : '' }}>BCA</option>
                    <option value="1" {{ old('status_pengontrak') == '1' ? 'selected' : '' }}>BRI</option>
                    <option value="2" {{ old('status_pengontrak') == '2' ? 'selected' : '' }}>Mandiri</option>
                    <option value="4" {{ old('status_pengontrak') == '4' ? 'selected' : '' }}>Tunai</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah_bca_sgls" id="label_harga_bca">Harga Sewa BCA (SGLS):</label>
                <input type="text" class="form-control" id="jumlah_bca_sgls" name="harga_bca_sgls" value="{{ old('jumlah_bca_sgls') }}"
                    onkeyup="formatInput(this)">
            </div>
            <div class="form-group">
                <label for="tgl_bca_sgls" id="label_tanggal_bca">Tanggal Pembayaran BCA (SGLS):</label>
                <input type="date" class="form-control" id="tgl_bca_sgls" name="tanggal_bca_sgls"
                    value="{{ old('tgl_bca_sgls') }}">
            </div>

            <div class="form-group">
                <label for="jumlah_bca_leo" id="label_harga_bri">Harga Sewa BCA (LEO):</label>
                <input type="text" class="form-control" id="harga_bri" name="harga_bca_leo" value="{{ old('harga_bri') }}"
                    onkeyup="formatInput(this)">
            </div>
            <div class="form-group">
                <label for="tgl_bca_leo" id="label_tanggal_bri">Tanggal Pembayaran BCA (LEO):</label>
                <input type="date" class="form-control" id="tgl_bca_leo" name="tanggal_bca_leo"
                    value="{{ old('tgl_bca_leo') }}">
            </div>

            <div class="form-group">
                <label for="jumlah_mandiri" id="label_harga_mandiri">Harga Sewa Mandiri:</label>
                <input type="text" class="form-control" id="jumlah_mandiri" name="jumlah_mandiri"
                    value="{{ old('jumlah_mandiri') }}" onkeyup="formatInput(this)">
            </div>
            <div class="form-group">
                <label for="tgl_mandiri" id="label_tanggal_mandiri">Tanggal Pembayaran Mandiri:</label>
                <input type="date" class="form-control" id="tgl_mandiri" name="tgl_mandiri"
                    value="{{ old('tgl_mandiri') }}">
            </div>

            <div class="form-group">
                <label for="jumlah_tunai" id="label_harga_tunai">Harga Sewa Tunai:</label>
                <input type="text" class="form-control" id="jumlah_tunai" name="jumlah_tunai"
                    value="{{ old('jumlah_tunai') }}" onkeyup="formatInput(this)">
            </div>
            <div class="form-group">
                <label for="tgl_tunai" id="label_tanggal_tunai">Tanggal Pembayaran Tunai:</label>
                <input type="date" class="form-control" id="tgl_tunai" name="tgl_tunai"
                    value="{{ old('tgl_mandiri') }}">
            </div>

            <div class="form-group">
                <label for="saldo_piutang">Status Saldo Piutang:</label>
                <select class="form-control" id="saldo_piutang" name="saldo_piutang">
                    <option value="0" {{ old('saldo_piutang') == '0' ? 'selected' : '' }}>Tidak Lunas</option>
                    <option value="1" {{ old('saldo_piutang') == '1' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status_pengontrak">Status Pengontrak:</label>
                <select class="form-control" id="status_pengontrak" name="status_pengontrak">
                    <option value="0" {{ old('status_pengontrak') == '0' ? 'selected' : '' }}>Perorangan</option>
                    <option value="1" {{ old('status_pengontrak') == '1' ? 'selected' : '' }}>Complimet</option>
                </select>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan Penghuni:</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
            </div>
            <div class="form-group">
                <label for="aktif">Status Aktif:</label>
                <select class="form-control" id="aktif" name="aktif">
                    <option value="0" {{ old('aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="1" {{ old('aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary ml-2" onclick="window.history.back()">Batal</button>
            </div>
        </form>
    </div>

    <script>
        // function formatInput(input) {
        //     let value = input.value.replace(/\D/g, '');
        //     value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        //     input.value = value;
        // }
        // document.getElementById('myForm').addEventListener('submit', function(event) {
        //     document.getElementById('upah_jasa').value = document.getElementById('upah_jasa').getAttribute('data-value');
        //     document.getElementById('harga_sewa').value = document.getElementById('harga_sewa').getAttribute('data-value');
        // });
        document.addEventListener("DOMContentLoaded", function() {
            var bankSelect = document.getElementById("bank_pembayaran");

            var labelBca = document.getElementById("label_harga_bca");
            var hargaBca = document.getElementById("jumlah_bca_sgls");
            var labelTanggalBca = document.getElementById("label_tanggal_bca");
            var tanggalBca = document.getElementById("tgl_bca_sgls");

            var labelBri = document.getElementById("label_harga_bri");
            var hargaBri = document.getElementById("harga_bri");
            var labelTanggalBri = document.getElementById("label_tanggal_bri");
            var tanggalBri = document.getElementById("tgl_bca_leo");

            var labelMandiri = document.getElementById("label_harga_mandiri");
            var hargaMandiri = document.getElementById("jumlah_mandiri");
            var labelTanggalMandiri = document.getElementById("label_tanggal_mandiri");
            var tanggalMandiri = document.getElementById("tgl_mandiri");

            var labelTunai = document.getElementById("label_harga_tunai");
            var hargaTunai = document.getElementById("jumlah_tunai");
            var labelTanggalTunai = document.getElementById("label_tanggal_tunai");
            var tanggalTunai = document.getElementById("tgl_tunai");

            // Initially hide the jumlah_bca_sgls input
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
                // If BRI is selected (value = 1), show the jumlah_bca_sgls input; otherwise, hide it
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
