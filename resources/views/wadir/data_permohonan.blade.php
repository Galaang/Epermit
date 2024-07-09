@extends('partials.app')

@section('container')
    <div class="container my-4">
        <h3 class="mb-3">Data Permohonan Izin</h3>
        <table class="table">
            <thead>
                <tr>
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
                            <div class="d-flex flex-column">
                                <form action="{{ route('edit_respon', $p->id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="hidden" name="status" value="Disetujui">
                                    <button type="submit" class="btn btn-primary btn-sm mb-2">
                                        Disetujui
                                    </button>
                                </form>
                                <form action="{{ route('edit_respon', $p->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="btn btn-danger btn-sm mb-2">
                                        Ditolak
                                    </button>
                                </form>
                            </div>
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Modal bukti --}}

                    {{-- Modal Respon --}}
                    <div class="modal fade" id="editStatus{{ $p->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Persetujuan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('edit_respon', $p->id) }}" method="POST">
                                        @csrf
                                        <select class="form-select" name="status" aria-label="Default select example">
                                            <option value="Disetujui">Disetujui</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Modal Respon --}}
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
