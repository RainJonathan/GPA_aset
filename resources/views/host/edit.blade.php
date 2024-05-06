@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Penyewa</h1>
    <form action="{{ route('host.update', $host->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_penyewa">Nama Penyewa:</label>
            <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa" value="{{$host->nama_penyewa}}">
        </div>
        <div class="form-group">
            <label for="no_ktp">No KTP:</label>
            <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{$host->no_ktp}}">
        </div>
        <div class="form-group">
            <label for="no_tlp">Nomor Telepon:</label>
            <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{$host->no_tlp}}">
        </div>
        <div class="form-group">
            <label for="tgl_awal">Tanggal Awal Masuk:</label>
            <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="{{$host->tgl_awal}}">
        </div>
        <div class="form-group">
            <label for="tgl_akhir">Tanggal Akhir:</label>
            <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" value="{{$host->tgl_akhir}}">
        </div>
        <div class="form-group">
            <label for="upah_jasa">Upah Jasa:</label>
            <input type="text" class="form-control" id="upah_jasa_display" name="upah_jasa_display" value="{{$host->upah_jasa}}">
            <input type="hidden" id="upah_jasa" name="upah_jasa" value="{{$host->upah_jasa}}">
          </div>
          
          <div class="form-group">
            <label for="harga_sewa">Harga Sewa:</label>
            <input type="text" class="form-control" id="harga_sewa_display" name="harga_sewa_display" value="{{$host->harga_sewa}}">
            <input type="hidden" id="harga_sewa" name="harga_sewa" value="{{$host->harga_sewa}}">
          </div>
          
        {{-- <div class="form-group">
            <label for="bank_pembayaran">Nama Bank Pembayaran:</label>
            <input type="text" class="form-control" id="bank_pembayaran" name="bank_pembayaran" value="{{$host->bank_pembayaran}}">
        </div>
        <div class="form-group">
            <label for="jumlah_pembayaran">Jumlah Pembayaran:</label>
            <input type="number" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" value="{{$host->jumlah_pembayaran}}">
        </div> --}}
        <div class="form-group">
            <label for="saldo_piutang">Status Saldo Piutang:</label>
            <select class="form-control" id="saldo_piutang" name="saldo_piutang">
                <option value="0">Tidak Lunas</option>
                <option value="1">Lunas</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status_pengontrak">Status Pengontrak:</label>
            <select class="form-control" id="status_pengontrak" name="status_pengontrak">
                <option value="0">Perorangan</option>
                <option value="1">Complimet</option>
            </select>
        </div>
        <div class="form-group">
            <label for="aktif">Status:</label>
            <select class="form-control" id="aktif" name="aktif">
                <option value="0">Tidak Aktif</option>
                <option value="1">Aktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary ml-2" onclick="window.history.back()">Batal</button>
    </form>
</div>

<script>
    $(document).ready(function() {
    $('.form-group input[type="text"]').on('input', function() {
      const value = $(this).val().replace(/\D/g, '');
      const formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      $(this).val(formattedValue);
  
      const hiddenInputId = $(this).attr('id').replace('_display', '');
      $('#' + hiddenInputId).val(value);
    });
  });
</script> 
@endsection