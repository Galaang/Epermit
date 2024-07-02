@extends('partials.app')

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
                            <h6 class="mb-0">1</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-clipboard-check-fill fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Izin Disetujui</p>
                            <h6 class="mb-0">2</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-clipboard-minus-fill fa-2x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Izin Ditolak</p>
                            <h6 class="mb-0">3</h6>
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
            3. Apabila izin pulang lebih cepat & izin terlambat datang harus menyertakan waktu.
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
                                <td>{{ $p->status }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#bukti{{ $p->id }}">
                                        Lihat
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editStatus{{ $p->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
