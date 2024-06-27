@extends('partials.app')

@section('container')
    <div class="container my-4">
        <h3 class="mb-3">Pegawai</h3>

        <div class="d-flex items-center justify-content-end me-5 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahpegawai">
                Tambah
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Jabatan</th>
                    <th scope="col">NIP/NPAK</th>
                    <th scope="col">Pangkat Jabatan</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Unit Kerja</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai as $p)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->nip }}</td>
                        <td>{{ $p->pangkat_jabatan->name }}</td>
                        <td>{{ $p->jabatan->name }}</td>
                        <td>{{ $p->unit->name }}</td>
                        <td class="d-flex gap-2">
                            <a href="#" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editpegawai{{ $p->id }}">Edit</a>
                            <form action="{{ route('hapus-pegawai', $p->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    {{-- modal edit pegawai --}}
                    <div class="modal fade" id="editpegawai{{ $p->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pegawai</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('edit-pegawai', $p->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $p->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">NIP/NPAK</label>
                                            <input type="number" class="form-control" name="nip" id="nip" value="{{ $p->nip }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pangkat jabatan/Gol</label>
                                            <select class="form-select" name="pangkat_jabatan_id" id="pangkat_jabatans"
                                                aria-label="jabatan">
                                                @foreach ($pangkat as $p)
                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>
                                            <select id="jabatanselect" class="form-select" name="jabatan_id" id="jabatans">
                                                @foreach ($jabatan as $j)
                                                    <option value="{{ $j->id }}">{{ $j->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Unit Kerja</label>
                                            <select class="form-select" name="unit_id" id="unit_ids"
                                                aria-label="Default select example">
                                                @foreach ($unit as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- modal end --}}
                @endforeach
            </tbody>
        </table>

        {{-- modal tambah pegawai --}}
        <div class="modal fade" id="tambahpegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Jabatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tambah-pegawai') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NPAK</label>
                                <input type="number" class="form-control" name="nip" id="nip">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pangkat jabatan/Gol</label>
                                <select class="form-select" name="pangkat_jabatan_id" id="pangkat_jabatan"
                                    aria-label="jabatan">
                                    @foreach ($pangkat as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select id="jabatanselect" class="form-select" name="jabatan_id" id="jabatan">
                                    @foreach ($jabatan as $j)
                                        <option value="{{ $j->id }}">{{ $j->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <select class="form-select" name="unit_id" id="unit_id"
                                    aria-label="Default select example">
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
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
        </div>
        {{-- modal end --}}

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tambahpegawai').on('shown.bs.modal', function() {
            $('#pangkat_jabatan').select2({
                dropdownParent: $('#tambahpegawai .modal-content')
            });
            $('#jabatan').select2({
                dropdownParent: $('#tambahpegawai .modal-content')
            });
            $('#unit_id').select2({
                dropdownParent: $('#tambahpegawai .modal-content')
            });
        });
    });
    // $(document).ready(function() {
    //     $('#editpegawai').on('shown.bs.modal', function() {
    //         $('#pangkat_jabatan').select2({
    //             dropdownParent: $('#tambahpegawai .modal-content')
    //         });
    //         $('#jabatan').select2({
    //             dropdownParent: $('#tambahpegawai .modal-content')
    //         });
    //         $('#unit_id').select2({
    //             dropdownParent: $('#tambahpegawai .modal-content')
    //         });
    //     });
    // });
</script>
