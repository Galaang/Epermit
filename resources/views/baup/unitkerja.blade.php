@extends('partials.app')

@section('container')
    <div class="container my-4">
        <h3 class="mb-3">Unit Kerja</h3>
        <div class="d-flex items-center justify-content-end me-5 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahunit">
                Tambah
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Unit Kerja</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unit as $u)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $u->name }}</td>
                        <td>
                            <a href="#" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editunit{{ $u->id }}">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    {{-- modal --}}
                    <div class="modal fade" id="editunit{{ $u->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('edit-unit-kerja', $u->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Nama Unit Kerja</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $u->name }}">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- modal end --}}
                @endforeach
            </tbody>
        </table>

        {{-- modal --}}
        <div class="modal fade" id="tambahunit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Unit Kerja</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tambah-unit-kerja') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Unit Kerja</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
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
