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
        <h3 class="mb-3">Pangkat Jabatan</h3>

        <div class="d-flex items-center justify-content-end me-5 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahpangkat">
                Tambah
            </button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Pangkat Jabatan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pangkat as $p)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $p->name }}</td>
                        <td class="d-flex">
                            <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#editpangkatjabatan{{ $p->id }}">Edit</a>
                            <form action="{{ route('hapus-pangkat-jabatan', $p->id) }}" method="POST"
                                id="delete-form-{{ $p->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <!-- <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDelete({{ $p->id }})">Hapus</button> -->
                        </td>
                    </tr>
                    {{-- modal --}}
                    <div class="modal fade" id="editpangkatjabatan{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pangkat Jabatan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('edit-pangkat-jabatan', $p->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Nama Pangkat Jabatan</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $p->name }}">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        <div class="modal fade" id="tambahpangkat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pangkat Jabatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tambah-pangkat-jabatan') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Pangkat Jabatan</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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


<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
