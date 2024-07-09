@extends('partials.app')

<head>
    <meta charset="utf-8">
    <title>E-Permit PNC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/logo.png" rel="icon">
</head>
@section('container')
    <div class="container my-4">
        <h3 class="mb-3">Formulir Permohonan Izin</h3>
        <form action="{{ route('form-insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control w-50" name="nama" id="name"
                    value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">NIP/NPAK</label>
                <input type="number" class="form-control w-50" name="nip" id="nip"
                    value="{{ Auth::user()->nip }}"readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Pangkat jabatan</label>
                <input type="text" class="form-control w-50" name="pangkat_jabatan" id="pangkat_jabatan"
                    value="{{ Auth::user()->pangkat_jabatan->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" class="form-control w-50" name="jabatan" id="jabatan"
                    value="{{ Auth::user()->jabatan->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Unit Kerja</label>
                <input type="text" class="form-control w-50" name="unit_kerja" id="unit_kerja"
                    value="{{ Auth::user()->unit->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Izin</label>
                <select class="form-select w-50" name="jenis_izin" id="jenisIzin" aria-label="Default select example">
                    <option value="Tidak Masuk Kerja">Tidak masuk kerja</option>
                    <option value="Pulang lebih cepat dari waktu kepulangan kerja">Pulang lebih cepat dari waktu kepulangan
                        kerja</option>
                    <option value="Terlambat datang masuk kerja">Terlambat datang masuk kerja</option>
                </select>
            </div>
            <div id="inputWaktu" class="d-none">
                <div class="mb-3">
                    <label for="waktu" class="form-label">Masukkan Waktu</label>
                    <input type="time" class="form-control w-50" id="waktu" name="waktu">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Izin ke-</label>
                <select class="form-select w-50" name="izin_ke" aria-label="Default select example">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                @if ($errors->any())
                    <div class="alert alert-danger w-50">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control w-50" name="tanggal" id="tanggal">
            </div>
            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan</label>
                <textarea class="form-control w-50" id="alasan" name="alasan" rows="3"></textarea>
            </div>
            <div class="mb-3 w-50">
                <label for="formFile" class="form-label">Bukti</label>
                <input class="form-control" class="form-control " name="bukti" type="file" id="formFile">
                <small class="form-text text-muted"> *format file PNG dengan ukuran maksimal 2 MB</small>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#jenisIzin').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Pulang lebih cepat dari waktu kepulangan kerja' || selectedValue ===
                'Terlambat datang masuk kerja') {
                $('#inputWaktu').removeClass('d-none').addClass('d-block');
            } else {
                $('#inputWaktu').removeClass('d-block').addClass('d-none');
            }
        });
    });
</script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        });
    </script>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // $(document).ready(function() {
    //     $('#jenisIzin').select2();
    // });
</script>
