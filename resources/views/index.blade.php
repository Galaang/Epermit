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
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $p->id }}">
                                            Edit
                                        </button>
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

                            {{-- Modal --}}
                    <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $p->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel{{ $p->id }}">Edit Permohonan
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('update', $p->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama"
                                                value="{{ $p->nama }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">NIP</label>
                                            <input type="number" class="form-control" name="nip"
                                                value="{{ $p->nip }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pangkat jabatan/Gol</label>
                                            <input type="text" class="form-control" name="pangkat_jabatan"
                                                value="{{ $p->pangkat_jabatan }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>
                                            <input type="text" class="form-control" name="jabatan"
                                                value="{{ $p->jabatan }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Unit Kerja</label>
                                            <input type="text" class="form-control" name="unit_kerja"
                                                value="{{ $p->unit_kerja }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Izin</label>
                                            <select class="form-select jenisIzin" name="jenis_izin"
                                                id="jenisIzin{{ $p->id }}" data-id="{{ $p->id }}"
                                                aria-label="Default select example">
                                                <option value="Tidak Masuk Kerja"
                                                    @if ($p->jenis_izin == 'Tidak Masuk Kerja') selected @endif>Tidak Masuk Kerja
                                                </option>
                                                <option value="Pulang lebih cepat dari waktu kepulangan kerja"
                                                    @if ($p->jenis_izin == 'Pulang lebih cepat dari waktu kepulangan kerja') selected @endif>Pulang lebih cepat
                                                    dari waktu kepulangan kerja</option>
                                                <option value="Terlambat datang masuk kerja"
                                                    @if ($p->jenis_izin == 'Terlambat datang masuk kerja') selected @endif>Terlambat datang masuk
                                                    kerja</option>
                                            </select>
                                        </div>
                                        <div id="inputWaktu{{ $p->id }}"
                                            class="{{ !$p->waktu ? 'd-none' : '' }}">
                                            <div class="mb-3">
                                                <label for="waktu" class="form-label">Masukkan Waktu</label>
                                                <input type="time" step="60" class="form-control" id="waktu"
                                                    name="waktu" value="{{ $p->waktu }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Izin ke-</label>
                                            <select class="form-select" name="izin_ke"
                                                aria-label="Default select example">
                                                <option value="1" @if ($p->izin_ke == 1) selected @endif>1
                                                </option>
                                                <option value="2" @if ($p->izin_ke == 2) selected @endif>2
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal"
                                                value="{{ $p->tanggal }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alasan" class="form-label">Alasan</label>
                                            <textarea class="form-control" id="alasan" name="alasan" rows="3">{{ $p->alasan }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Bukti</label>
                                            <input class="form-control" class="form-control w-50" name="bukti"
                                                type="file" id="formFile">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
