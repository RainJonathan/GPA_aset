@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"> Update Perbaikan?</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('tiket.update', $tiket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_aset">Nama Asset:</label>
                                <select class="form-control" id="id_aset" name="id_aset">
                                    <option value="">Pilih Aset</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" {{ $tiket->id_aset == $asset->id ? 'selected' : '' }}>
                                            {{ $asset->nama_aset }} - {{ $asset->kode_aset }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan Perbaikan:</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $tiket->keterangan }}" placeholder="Apa yang perlu diperbaiki">
                            </div>

                            <div class="form-group">
                                <label for="status">Status Perbaikan:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Pending" {{ $tiket->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $tiket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ $tiket->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ $tiket->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penyelesaian">Keterangan Penyelesaian:</label>
                                <input type="text" class="form-control" id="penyelesaian" name="penyelesaian" value="{{ $tiket->penyelesaian }}" placeholder="Perbaikan apa yang telah dilakukan?">
                            </div>
                            <div class="form-group">
                                <label for="biaya_perbaikan">Biaya Perbaikan:</label>
                                <input type="text" class="form-control currency" id="biaya_perbaikan" name="biaya_perbaikan" value="{{ $tiket->biaya_perbaikan }}" placeholder="Berapa biaya perbaikannya?" onkeyup="formatInput(this)">
                            </div>
                            <div class="form-group">
                                <label for="user_id">Pelapor:</label>
                                <select class="form-control" id="user_id" name="user_id">
                                    <option value="">Select Pelapor</option>
                                    @foreach($overseers as $overseer)
                                        <option value="{{ $overseer->id }}" {{ $tiket->user_id == $overseer->id ? 'selected' : '' }}>{{ $overseer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if($tiket->photo->count() > 0)
                                <div class="form-group">
                                    <label>Foto Saat Ini:</label> <br>
                                    <div class="row">
                                        @foreach($tiket->photo as $photo)
                                            <div class="col-md-4" style="height: 100%; overflow: hidden;">
                                                <img src="{{ asset('before_photos/' . $photo->before_photo) }}" alt="Photo" class="img-fluid">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="before_photo">Edit Foto Fasilitas Yang Rusak?</label>
                                <input type="file" class="form-control-file" id="before_photo" name="before_photo[]" accept="image/*" multiple>
                            </div>
                            <div class="form-group">
                                <label for="after_photo">Foto Fasilitas Rusak yang Telah Diperbaiki</label>
                                <input type="file" class="form-control-file" id="after_photo" name="after_photo[]" accept="image/*" multiple>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary ml-2" onclick="window.location.href='{{ route('tiket.index') }}'">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function formatInput(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value) {
            value = parseInt(value, 10).toLocaleString();
        }
        input.value = value;
    }

    function unformatInput(input) {
        return input.value.replace(/[^0-9]/g, '');
    }

    document.getElementById('currencyForm').addEventListener('submit', function(event) {
        let currencyFields = document.querySelectorAll('.currency');
        currencyFields.forEach(function(field) {
            field.value = unformatInput(field);
        });
    });
</script>
@endsection
