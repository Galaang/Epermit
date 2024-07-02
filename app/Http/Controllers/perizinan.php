<?php

namespace App\Http\Controllers;

use App\Models\perizinan as ModelsPerizinan;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class perizinan extends Controller
{
    public function form_izin()
    {
        return view('form_izin');
    }

    public function insert(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nip' => 'required',
            'pangkat_jabatan' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'jenis_izin' => 'required',
            'waktu' => 'required_if:jenis_izin,Pulang lebih cepat dari waktu kepulangan kerja,Terlambat datang masuk kerja',
            'izin_ke' => 'required',
            'tanggal' => 'required|date',
            'alasan' => 'required',
            'bukti' => 'required|file|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('bukti')) {
            $filePath = $request->file('bukti')->store('bukti_perizinan'); // Simpan file di dalam folder 'storage/app/public/bukti_perizinan'
        }

        $validatedData = $validator->validated();

        $user = auth()->user();

        $perizinan = new ModelsPerizinan();
        $perizinan->user_id = $user->id;
        $perizinan->nama = $validatedData['nama'];
        $perizinan->nip = $validatedData['nip'];
        $perizinan->pangkat_jabatan = $validatedData['pangkat_jabatan'];
        $perizinan->jabatan = $validatedData['jabatan'];
        $perizinan->unit_kerja = $validatedData['unit_kerja'];
        $perizinan->jenis_izin = $validatedData['jenis_izin'];
        $perizinan->waktu = $validatedData['waktu'];
        $perizinan->izin_ke = $validatedData['izin_ke'];
        $perizinan->tanggal = $validatedData['tanggal'];
        $perizinan->alasan = $validatedData['alasan'];
        $perizinan->bukti = $filePath;
        $perizinan->status = 'diproses';
        $perizinan->save();


        return redirect()->route('dashboard')->with('success', 'Permohonan izin berhasil diajukan.');
    }

    public function riwayat_permohonan()
    {
        $user = Auth::user();
        $perizinan = ModelsPerizinan::where('user_id', $user->id)->get();
        return view('riwayat_permohonan', compact('perizinan'));
    }

    public function data_permohonan()
    {
        // Periksa jurusan pengguna yang sedang login
        $user = Auth::user();
        // Pastikan pengguna adalah Kaprodi
        if ($user->jabatan_id == 2) {
            // Mengambil perizinan yang sesuai dengan jurusan pengguna yang sedang login
            $perizinan = ModelsPerizinan::whereHas('user', function ($query) use ($user) {
                $query->where('jabatan', 'Dosen')
                    ->where('unit_kerja', $user->unit->name);
            })->with('user')->get();

            return view('kaprodi.data_permohonan', compact('perizinan'));
        } else {
            // Jika pengguna tidak memiliki akses, redirect atau tampilkan pesan error
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk melihat data ini.');
        }
    }

    public function data_permohonan_kajur()
    {
        // Periksa jurusan pengguna yang sedang login
        $user = Auth::user();
        // Pastikan pengguna adalah Kaprodi
        if ($user->jabatan_id == 3) {
            // Mengambil perizinan yang sesuai dengan jurusan pengguna yang sedang login
            $perizinan = ModelsPerizinan::whereHas('user', function ($query) use ($user) {
                $query->where('jabatan', 'Ketua Prodi')
                    ->where('unit_kerja', $user->unit->name);
            })->with('user')->get();

            return view('kajur.data_permohonan', compact('perizinan'));
        } else {
            // Jika pengguna tidak memiliki akses, redirect atau tampilkan pesan error
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk melihat data ini.');
        }
    }

    public function data_permohonan_wadir()
    {
        $perizinan = ModelsPerizinan::all();
        return view('wadir.data_permohonan', compact('perizinan'));
    }


    public function editRespon(Request $request, $id)
    {
        $perizinan = ModelsPerizinan::findOrFail($id);
        $perizinan->status = $request->input('status');
        $perizinan->save();
        return redirect()->back()->with('success', 'status berhasil diupdate.');
    }


    public function riwayatpermohonanBaup()
    {
        $perizinan = ModelsPerizinan::all();
        return view('baup.riwayatpermohonan', compact('perizinan'));
    }


    public function update(Request $request, $id)
    {
        $perizinan = ModelsPerizinan::findOrFail($id);

        // Validasi data yang diterima dari request
        $request->validate([
            'jenis_izin' => 'required|string',
            'izin_ke' => 'required|integer',
            'tanggal' => 'required|date',
            'alasan' => 'required|string',
            'bukti' => 'nullable|file|max:10240', // Tambahkan batas maksimal ukuran file 10MB
        ]);

        // Set waktu ke null jika jenis izin adalah 'Tidak Masuk Kerja'
        $jenis_izin = $request->input('jenis_izin');
        if ($jenis_izin === 'Tidak Masuk Kerja') {
            $waktu = null;
        } else {
            // Jika jenis izin bukan 'Tidak Masuk Kerja', ambil waktu dari input
            $waktu = $request->input('waktu');
        }

        // Handle file upload jika ada file baru
        if ($request->hasFile('bukti')) {
            // Hapus file lama jika ada
            if ($perizinan->bukti) {
                Storage::delete($perizinan->bukti);
            }

            // Simpan file baru
            $filePath = $request->file('bukti')->store('bukti_perizinan'); // Simpan file di dalam folder 'storage/app/public/bukti_perizinan'
            $perizinan->bukti = $filePath;
        }

        // Update data perizinan
        $perizinan->jenis_izin = $jenis_izin;
        $perizinan->waktu = $waktu;
        $perizinan->izin_ke = $request->input('izin_ke');
        $perizinan->tanggal = $request->input('tanggal');
        $perizinan->alasan = $request->input('alasan');

        // Simpan perubahan ke database
        $perizinan->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data perizinan berhasil diupdate.');
    }
}
