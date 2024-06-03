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
                                    <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa"
                                        value="{{ $host->nama_penyewa }}">
                                </div>
                                <div class="form-group">
                                    <label for="no_ktp">No KTP:</label>
                                    <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                                        value="{{ $host->no_ktp }}">
                                </div>
                                <div class="form-group">
                                    <label for="wilayah_id">Wilayah Penyewa:</label>
                                    <select class="form-control" id="wilayah_id" name="wilayah_id">
                                        <option value="">Select Wilayah</option>
                                        @foreach ($wilayahs as $wilayah)
                                            <option value="{{ $wilayah->id }}"
                                                {{ (old('wilayah_id') ?? $host->wilayah_id) == $wilayah->id ? 'selected' : '' }}>
                                                {{ $wilayah->nama_wilayah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="asset_id">Aset yang disewa:</label>
                                    <select class="form-control" id="asset_id" name="asset_id">
                                        <option value="">-- Pilih Aset --</option>
                                        @foreach ($assets as $asset)
                                            <option value="{{ $asset->id }}"
                                                {{ old('asset_id', $host->asset_id) == $asset->id ? 'selected' : '' }}>
                                                {{ $asset->kode_aset }} - {{ $asset->no_rumah }} - {{ $asset->alamat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="no_tlp">Nomor Telepon:</label>
                                    <input type="text" class="form-control" id="no_tlp" name="no_tlp"
                                        value="{{ $host->no_tlp }}">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_awal">Tanggal Awal Masuk:</label>
                                    <input type="date" class="form-control" id="tgl_awal" name="tgl_awal"
                                        value="{{ $host->tgl_awal }}">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_akhir">Tanggal Akhir:</label>
                                    <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir"
                                        value="{{ $host->tgl_akhir }}">
                                </div>
                                <div class="form-group">
                                    <label for="upah_jasa">Upah Jasa:</label>
                                    <input type="text" class="form-control" id="upah_jasa" name="upah_jasa"
                                        value="{{ $host->upah_jasa }}" onkeyup="formatInput(this)">
                                </div>
                                <div class="form-group">
                                    <label for="harga_sewa">Harga Sewa:</label>
                                    <input type="text" class="form-control" id="harga_sewa" name="harga_sewa"
                                        value="{{ $host->previousOwner ? $host->previousOwner->harga_sewa : '0' }}"
                                        onkeyup="formatInput(this)">
                                </div>
                                <div class="form-group">
                                    <label for="status_penyewaan">Status Penyewaan:</label>
                                    <select class="form-control" id="status_penyewaan" name="status_penyewaan">
                                        <option value="Mingguan"
                                            {{ (old('status_penyewaan') ?? $host->status_penyewaan) == 'Mingguan' ? 'selected' : '' }}>
                                            Mingguan</option>
                                        <option value="Bulanan"
                                            {{ (old('status_penyewaan') ?? $host->status_penyewaan) == 'Bulanan' ? 'selected' : '' }}>
                                            Bulanan</option>
                                        <option value="Tahunan"
                                            {{ (old('status_penyewaan') ?? $host->status_penyewaan) == 'Tahunan' ? 'selected' : '' }}>
                                            Tahunan</option>
                                        <option value="Tidak Menyewa"
                                            {{ (old('status_penyewaan') ?? $host->status_penyewaan) == 'Tidak Menyewa' ? 'selected' : '' }}>
                                            Tidak Menyewa</option>
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                <label for="status_penyewaan">Status Penyewaan:</label>
                                <select class="form-control" id="status_penyewaan" name="status_penyewaan">
                                    <option value="Mingguan" {{ old('status_penyewaan') == 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="Bulanan" {{ old('status_penyewaan') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="Tahunan" {{ old('status_penyewaan') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                                </select>
                            </div> --}}
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bank_pembayaran">Bank Pembayaran:</label>
                                    <select class="form-control" id="bank_pembayaran" name="bank_pembayaran">
                                        <option value="" disabled selected>Please choose</option>
                                        <option value="0" {{ $host->bank_pembayaran == '0' ? 'selected' : '' }}>BCA
                                            (SGLS)
                                        </option>
                                        <option value="1" {{ $host->bank_pembayaran == '1' ? 'selected' : '' }}>BCA
                                            (LEO)
                                        </option>
                                        <option value="2" {{ $host->bank_pembayaran == '2' ? 'selected' : '' }}>
                                            Mandiri</option>
                                        <option value="3" {{ $host->bank_pembayaran == '3' ? 'selected' : '' }}>Tunai
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="harga_bca" id="label_harga_bca">Harga Sewa BCA (SGLS):</label>
                                    <input type="text" class="form-control" id="harga_bca" name="harga_bca_sgls"
                                        value="{{ $host->harga_bca_sgls }}" onkeyup="formatInput(this)">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_bca" id="label_tanggal_bca">Tanggal Pembayaran BCA (SGLS):</label>
                                    <input type="date" class="form-control" id="tanggal_bca" name="tanggal_bca_sgls"
                                        value="{{ $host->tanggal_bca_sgls }}">
                                </div>


                                <div class="form-group">
                                    <label for="harga_bri" id="label_harga_bri">Harga Sewa BCA (LEO):</label>
                                    <input type="text" class="form-control" id="harga_bri" name="harga_bca_leo"
                                        value="{{ $host->harga_bca_leo }}" onkeyup="formatInput(this)">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_bri" id="label_tanggal_bri">Tanggal Pembayaran BCA (LEO):</label>
                                    <input type="date" class="form-control" id="tanggal_bri" name="tanggal_bca_leo"
                                        value="{{ $host->tanggal_bca_leo }}">
                                </div>


                                <div class="form-group">
                                    <label for="harga_mandiri" id="label_harga_mandiri">Harga Sewa Mandiri:</label>
                                    <input type="text" class="form-control" id="harga_mandiri" name="harga_mandiri"
                                        value="{{ $host->harga_mandiri }}" onkeyup="formatInput(this)">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mandiri" id="label_tanggal_mandiri">Tanggal Pembayaran
                                        Mandiri:</label>
                                    <input type="date" class="form-control" id="tanggal_mandiri"
                                        name="tanggal_mandiri" value="{{ $host->tanggal_mandiri }}">
                                </div>


                                <div class="form-group">
                                    <label for="harga_tunai" id="label_harga_tunai">Harga Sewa Tunai:</label>
                                    <input type="text" class="form-control" id="harga_tunai" name="harga_tunai"
                                        value="{{ $host->harga_tunai }}" onkeyup="formatInput(this)">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_tunai" id="label_tanggal_tunai">Tanggal Pembayaran Tunai:</label>
                                    <input type="date" class="form-control" id="tanggal_tunai" name="tanggal_tunai"
                                        value="{{ $host->tanggal_tunai }}">
                                </div>
                                <div class="form-group">
                                    <label for="denda_tunai" id="label_denda_tunai">Denda Pembayaran Tunai:</label>
                                    <input type="text" class="form-control" id="denda_tunai" name="denda_tunai">
                                </div>
                                <div class="form-group">
                                    <label for="denda_bca" id="label_denda_bca">Denda Pembayaran BCA (SGLS):</label>
                                    <input type="text" class="form-control" id="denda_bca" name="denda_bca">
                                </div>
                                <div class="form-group">
                                    <label for="denda_mandiri" id="label_denda_mandiri">Denda Pembayaran Mandiri:</label>
                                    <input type="text" class="form-control" id="denda_mandiri" name="denda_mandiri">
                                </div>

                                <div class="form-group">
                                    <label for="saldo_piutang">Status Saldo Piutang:</label>
                                    <select class="form-control" id="saldo_piutang" name="saldo_piutang">
                                        <option value="0" {{ $host->saldo_piutang == '0' ? 'selected' : '' }}>Tidak
                                            Lunas</option>
                                        <option value="1" {{ $host->saldo_piutang == '1' ? 'selected' : '' }}>Lunas
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="denda_bri" id="label_denda_bri">Denda Pembayaran BCA (LEO):</label>
                                    <input type="text" class="form-control" id="denda_bri" name="denda_bri">
                                </div>

                                <div class="form-group">
                                    <label for="status_pengontrak">Status Pengontrak:</label>
                                    <select class="form-control" id="status_pengontrak" name="status_pengontrak">
                                        <option value="0" {{ $host->status_pengontrak == '0' ? 'selected' : '' }}>
                                            Perorangan</option>
                                        <option value="1" {{ $host->status_pengontrak == '1' ? 'selected' : '' }}>
                                            Complimet</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status_aktif">Status Aktif:</label>
                                    <select class="form-control" id="status_aktif" name="status_aktif">
                                        <option value="0" {{ $host->status_aktif == '0' ? 'selected' : '' }}>Tidak
                                            Aktif</option>
                                        <option value="1" {{ $host->status_aktif == '1' ? 'selected' : '' }}>Aktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
            var statusPenyewaan = document.getElementById("status_penyewaan");

            var labelBca = document.getElementById("label_harga_bca");
            var hargaBca = document.getElementById("harga_bca");
            var labelTanggalBca = document.getElementById("label_tanggal_bca");
            var tanggalBca = document.getElementById("tanggal_bca");
            var labelDendaBca = document.getElementById("label_denda_bca");
            var dendaBca = document.getElementById("denda_bca");

            var labelBri = document.getElementById("label_harga_bri");
            var hargaBri = document.getElementById("harga_bri");
            var labelTanggalBri = document.getElementById("label_tanggal_bri");
            var tanggalBri = document.getElementById("tanggal_bri");
            var labelDendaBri = document.getElementById("label_denda_bri");
            var dendaBri = document.getElementById("denda_bri");

            var labelMandiri = document.getElementById("label_harga_mandiri");
            var hargaMandiri = document.getElementById("harga_mandiri");
            var labelTanggalMandiri = document.getElementById("label_tanggal_mandiri");
            var tanggalMandiri = document.getElementById("tanggal_mandiri");
            var labelDendaMandiri = document.getElementById("label_denda_mandiri");
            var dendaMandiri = document.getElementById("denda_mandiri");

            var labelTunai = document.getElementById("label_harga_tunai");
            var hargaTunai = document.getElementById("harga_tunai");
            var labelTanggalTunai = document.getElementById("label_tanggal_tunai");
            var tanggalTunai = document.getElementById("tanggal_tunai");
            var labelDendaTunai = document.getElementById("label_denda_tunai");
            var dendaTunai = document.getElementById("denda_tunai");

            function updateFieldVisibility() {
                var selectedBank = bankSelect.value;
                var penyewaanStatus = statusPenyewaan.value;

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

                labelTunai.style.display = selectedBank === "3" ? "block" : "none";
                hargaTunai.style.display = selectedBank === "3" ? "block" : "none";
                labelTanggalTunai.style.display = selectedBank === "3" ? "block" : "none";
                tanggalTunai.style.display = selectedBank === "3" ? "block" : "none";

                var daysDifference;
                if (selectedBank === "0") {
                    daysDifference = calculateDaysDifference(tanggalBca.value);
                } else if (selectedBank === "1") {
                    daysDifference = calculateDaysDifference(tanggalBri.value);
                } else if (selectedBank === "2") {
                    daysDifference = calculateDaysDifference(tanggalMandiri.value);
                } else if (selectedBank === "3") {
                    daysDifference = calculateDaysDifference(tanggalTunai.value);
                }

                checkDenda(penyewaanStatus, daysDifference);
            }

            function calculateDaysDifference(dateString) {
                var selectedDate = new Date(dateString);
                var currentDate = new Date();
                var timeDifference = selectedDate.getTime() - currentDate.getTime();
                var daysDifference = Math.abs(Math.ceil(timeDifference / (1000 * 3600 * 24)));
                return daysDifference;
            }

            function checkDenda(penyewaanStatus, daysDifference) {
                var selectedBank = bankSelect.value;

                labelDendaBca.style.display = "none";
                dendaBca.style.display = "none";
                labelDendaBri.style.display = "none";
                dendaBri.style.display = "none";
                labelDendaMandiri.style.display = "none";
                dendaMandiri.style.display = "none";
                labelDendaTunai.style.display = "none";
                dendaTunai.style.display = "none";

                if (penyewaanStatus === "Mingguan" && daysDifference > 7) {
                    if (selectedBank === "0") {
                        labelDendaBca.style.display = "block";
                        dendaBca.style.display = "block";
                    } else if (selectedBank === "1") {
                        labelDendaBri.style.display = "block";
                        dendaBri.style.display = "block";
                    } else if (selectedBank === "2") {
                        labelDendaMandiri.style.display = "block";
                        dendaMandiri.style.display = "block";
                    } else if (selectedBank === "3") {
                        labelDendaTunai.style.display = "block";
                        dendaTunai.style.display = "block";
                    }
                } else if (penyewaanStatus === "Bulanan" && daysDifference > 31) {
                    if (selectedBank === "0") {
                        labelDendaBca.style.display = "block";
                        dendaBca.style.display = "block";
                    } else if (selectedBank === "1") {
                        labelDendaBri.style.display = "block";
                        dendaBri.style.display = "block";
                    } else if (selectedBank === "2") {
                        labelDendaMandiri.style.display = "block";
                        dendaMandiri.style.display = "block";
                    } else if (selectedBank === "3") {
                        labelDendaTunai.style.display = "block";
                        dendaTunai.style.display = "block";
                    }
                } else if (penyewaanStatus === "Tahunan" && daysDifference > 365) {
                    if (selectedBank === "0") {
                        labelDendaBca.style.display = "block";
                        dendaBca.style.display = "block";
                    } else if (selectedBank === "1") {
                        labelDendaBri.style.display = "block";
                        dendaBri.style.display = "block";
                    } else if (selectedBank === "2") {
                        labelDendaMandiri.style.display = "block";
                        dendaMandiri.style.display = "block";
                    } else if (selectedBank === "3") {
                        labelDendaTunai.style.display = "block";
                        dendaTunai.style.display = "block";
                    }
                }
            }

            bankSelect.addEventListener("change", updateFieldVisibility);
            updateFieldVisibility
        (); // Call this function initially to set the correct visibility based on the current selected bank

            // Calculate initial differences on load and check denda
            checkDenda(statusPenyewaan.value, calculateDaysDifference(tanggalBca.value));
            checkDenda(statusPenyewaan.value, calculateDaysDifference(tanggalBri.value));
            checkDenda(statusPenyewaan.value, calculateDaysDifference(tanggalMandiri.value));
            checkDenda(statusPenyewaan.value, calculateDaysDifference(tanggalTunai.value));
        });
    </script>

@endsection
