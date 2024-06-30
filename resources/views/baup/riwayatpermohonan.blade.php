@extends('partials.app')

@section('container')
    <div class="container my-4">
        <h2 class="mb-3">Riwayat Permohonan</h2>
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
                        <td>{{ $p->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
