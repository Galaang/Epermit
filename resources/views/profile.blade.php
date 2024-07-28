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
        <h3 class="mb-3">Profil</h3>
        <form action="{{ route('edit_profile') }}" method="POST">
            @csrf
            {{-- @method('PUT') --}}
            <div class="border p-2 mb-3 rounded">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', Auth::user()->name) }}">
                </div>
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP/NPAK</label>
                    <input type="text" class="form-control" id="nip" name="nip"
                        value="{{ old('nip', Auth::user()->nip) }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', Auth::user()->email) }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                </div>
            </div>

            <div class="border p-2 rounded">
                <h3>Edit Password</h3>
                <div class="mb-3">
                    <label for="password_lama" class="form-label">Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" id="password_lama">
                    @if ($errors->has('password_lama'))
                        <span class="text-danger">{{ $errors->first('password_lama') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="password_baru" class="form-label">Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" id="password_baru">
                    @if (!empty($errors->first('password_baru')))
                        <span class="text-danger">{{ $errors->first('password_baru') }}</span>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
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
