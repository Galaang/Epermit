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
        <h2 class="mb-3">Riwayat Permohonan</h2>
        <div class="d-flex justify-content-end items-center me-3 mb-3">
            <a href="{{ route('cetakPdf') }}" target="_blank" class="btn btn-primary">Cetak</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">NIP</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Jenis Izin</th>
                    <th scope="col">Waktu</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Alasan</th>
                    <th scope="col">Status</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($perizinan as $p)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nip }}</td>
                        <td>{{ $p->jabatan }}</td>
                        <td>{{ $p->jenis_izin }}</td>
                        <td>{{ $p->waktu ?? '-' }}</td>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ $p->alasan }}</td>
                        <td>
                            @if ($p->status == 'Pending')
                                <span class="badge rounded-pill bg-warning">{{ $p->status }}</span>
                            @elseif ($p->status == 'Disetujui')
                                <span class="badge rounded-pill bg-success">{{ $p->status }}</span>
                            @elseif ($p->status == 'Ditolak')
                                <span class="badge rounded-pill bg-danger">{{ $p->status }}</span>
                            @else
                                <span class="badge rounded-pill bg-secondary">{{ $p->status }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

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