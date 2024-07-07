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
                        <td>{{ $p->waktu ?? '-' }}</td>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ $p->alasan }}</td>
                        <td>
                        @if ($p->status == 'diproses')
                                <span class="badge rounded-pill bg-warning">{{ $p->status }}</span>
                            @endif
                            @if ($p->status == 'Pending')
                                <span class="badge rounded-pill bg-warning">{{ $p->status }}</span>
                            @endif
                            @if ($p->status == 'Disetujui')
                                <span class="badge rounded-pill bg-success">{{ $p->status }}</span>
                            @endif
                            @if ($p->status == 'Ditolak')
                                <span class="badge rounded-pill bg-danger">{{ $p->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" type="button" data-bs-toggle="modal"
                                data-bs-target="#bukti{{ $p->id }}" class="btn btn-secondary btn-sm">Lihat</a>
                        </td>
                        <td>
                            @if ($p->status == 'Disetujui')
                                <button href="#" disabled type="button" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $p->id }}" class="btn btn-primary btn-sm">Edit
                                    </but>
                                @else
                                    <button href="#" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $p->id }}"
                                        class="btn btn-primary btn-sm">Edit</button>
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
                                            <img src="{{ asset('storage/' . $p->bukti) }}" class="">
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
                                            <label class="form-label">NIP/NPAK</label>
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
                                                data-bs-dismiss="modal">Close</button>
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
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.jenisIzin').change(function() {
            var id = $(this).data('id');
            var selectedValue = $(this).val();
            if (selectedValue === 'Pulang lebih cepat dari waktu kepulangan kerja' || selectedValue ===
                'Terlambat datang masuk kerja') {
                $('#inputWaktu' + id).removeClass('d-none').addClass('d-block');
            } else {
                $('#inputWaktu' + id).removeClass('d-block').addClass('d-none');
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script>
    function updateData(id) {
        // Submit form using AJAX or fetch API
        var form = document.getElementById('updateForm' + id);
        var formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Close modal
                $('#editModal' + id).modal('hide');

                // Show success message with SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil diperbarui.',
                    timer: 2000, // Durasi pesan success
                    showConfirmButton: false // Tidak tampilkan tombol OK
                });

                // Optionally, you can reload the page or update the UI
                // window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat memperbarui data.',
                });
            });
    }
</script> --}}
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
