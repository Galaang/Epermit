@extends('partials.app')

@section('container')
    <div class="container my-4">
        <h1 class="mb-3">Profile</h1>
        <form action="{{ route('edit_profile') }}" method="POST">
            @csrf
            {{-- @method('PUT') --}}

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', Auth::user()->name) }}">
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">NIDN/NPAK</label>
                <input type="text" class="form-control" id="nip" name="nip"
                    value="{{ old('nip', Auth::user()->nip) }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', Auth::user()->email) }}">
            </div>
            <div class="mb-3">
                <label for="password_lama" class="form-label">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" id="password_lama">
                @error('password_lama')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_baru" class="form-label">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" id="password_baru">
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