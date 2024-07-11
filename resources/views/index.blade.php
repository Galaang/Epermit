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
        <h5>Selamat datang di E-Permit Politeknik Negeri Cilacap!</h5>

        <div class="container-fluid pt-4 px-4 mb-3">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-clipboard-fill fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Permohonan Izin</p>
                            <h6 class="mb-0">{{ $total_perizinan }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-clipboard-check-fill fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Izin Disetujui</p>
                            <h6 class="mb-0">{{ $perizinan_disetujui }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-clipboard-minus-fill fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Izin Ditolak</p>
                            <h6 class="mb-0">{{ $perizinan_ditolak }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border border-2 p-2 rounded mb-3">
            <p class="fw-bold"><i class="bi bi-file-earmark-text-fill"></i> Ketentuan Permohonan Izin</p>
            <p>
                1. Jenis Izin:
            <ul>
                <li>Tidak masuk kerja</li>
                <li>Pulang lebih cepat dari waktu kepulangan kerja</li>
                <li>Terlambat datang masuk kerja</li>
            </ul>
            2. Permohonan izin maksimal dilakukan 2 kali selama 1 bulan per setiap jenis izin.<br>
            3. Apabila izin pulang lebih cepat & izin terlambat datang harus menyertakan waktu.<br>
            4. Izin dapat dibatalkan jika belum dilaksanakan sesuai waktu yang diajukan.
            </p>
        </div>

        <div class="border border-2 p-2 rounded">
            <p class="fw-bold"><i class="bi bi-calendar-fill me-2"></i>Riwayat Permohonan</p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP/NPAK</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Jenis Izin</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Alasan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Bukti</th>
                            <th scope="col">Aksi</th>
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
                                @if ($p->waktu)
                                    <td>{{ $p->waktu }}</td>
                                @else
                                    <td> - </td>
                                @endif
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
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#bukti{{ $p->id }}">
                                        Lihat
                                    </button>
                                </td>
                                <td>
                                    @if ($p->status == 'Disetujui')
                                        <button type="button" disabled class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#editStatus{{ $p->id }}">
                                            Edit
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editStatus{{ $p->id }}">
                                            Edit
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            {{-- Modal bukti --}}
                            <div class="modal fade" id="bukti{{ $p->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="img-fluid d-flex item-center justify-content-center">
                                                @if ($p->bukti == null)
                                                    <p>Belum ada bukti</p>
                                                @else
                                                    <img src="{{ asset('storage/' . $p->bukti) }}" class="img-fluid">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal bukti --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
