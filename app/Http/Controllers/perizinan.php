<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\IzinDiajukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\perizinan as ModelsPerizinan;
use App\Models\Unit_kerja;

class perizinan extends Controller
{
    public function form_izin()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $izinData = [];

        $jenisIzinList = [
            'Tidak Masuk Kerja',
            'Pulang lebih cepat dari waktu kepulangan kerja',
            'Terlambat datang masuk kerja'
        ];

        foreach ($jenisIzinList as $jenisIzin) {
            $izinData[$jenisIzin]['izin_ke_1'] = ModelsPerizinan::where('user_id', $user->id)
                ->where('jenis_izin', $jenisIzin)
                ->where('izin_ke', 1)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->exists();

            $izinData[$jenisIzin]['izin_ke_2'] = ModelsPerizinan::where('user_id', $user->id)
                ->where('jenis_izin', $jenisIzin)
                ->where('izin_ke', 2)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->exists();
        }


        return view('form_izin', compact('izinData'));
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nip' => 'required',
            'pangkat_jabatan' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'jenis_izin' => 'required',
            'waktu' => 'required_if:jenis_izin,Pulang lebih cepat dari waktu kepulangan kerja,Terlambat datang masuk kerja',
            'izin_ke' => 'required|integer|in:1,2',
            'tanggal' => ['required', 'date', function ($attribute, $value, $fail) {
                $today = Carbon::today();
                $requestedDate = Carbon::parse($value);
                if (!$requestedDate->isSameDay($today->subDay()) && !$requestedDate->isSameDay($today) && !$requestedDate->isSameDay($today->addDay())) {
                    // $fail('Tanggal izin harus satu hari sebelum, hari ini, atau satu hari setelah tanggal hari ini.');
                }
            }],
            'alasan' => 'required',
            'bukti' => 'required|mimes:jpg,jpeg,png|max:5120',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->jenis_izin == 'Pulang lebih cepat dari waktu kepulangan kerja') {
                $requestedDate = Carbon::parse($request->tanggal);
                $requestedTime = Carbon::parse($request->waktu);
                $currentDateTime = Carbon::now();

                // Validasi agar izin tidak bisa dilakukan jika waktu yang diminta sudah terlewati pada hari yang sama
                if ($requestedDate->isToday() && $requestedTime->lessThan($currentDateTime)) {
                    $validator->errors()->add('waktu', 'Izin pulang lebih cepat hanya bisa dilakukan sebelum waktu yang diminta.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if izin ke-1 has already been selected
        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        if ($request->izin_ke == 1) {
            $existingIzinKe1Count = ModelsPerizinan::where('user_id', $user->id)
                ->where('jenis_izin', $request->jenis_izin)
                ->where('izin_ke', 1)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();

            if ($existingIzinKe1Count > 0) {
                return redirect()->back()->withErrors(['izin_ke' => 'Izin ke-1 sudah pernah diajukan, pilih izin ke-2.'])->withInput();
            }
        }

        // Check if each jenis_izin has been selected more than 2 times in the current month
        $existingIzinCount = ModelsPerizinan::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('jenis_izin', $request->jenis_izin)
            ->count();

        if ($existingIzinCount >= 2) {
            return redirect()->back()->withErrors(['jenis_izin' => 'Izin ' . $request->jenis_izin . ' hanya dapat dipilih sebanyak 2 kali dalam 1 bulan.'])->withInput();
        }


        $filePath = null;
        if ($request->hasFile('bukti')) {
            $filePath = $request->file('bukti')->store('bukti_perizinan');
        }

        // Ambil data unit berdasarkan unit_id dari user

        $unit = Unit_kerja::where('id', $user->unit_id)->first();

        if (!$unit) {
            return redirect()->back()->withErrors(['unit_id' => 'Unit tidak valid atau tidak ditemukan.'])->withInput();
        }

        // Ambil data ketua prodi berdasarkan unit_id
        $ketuaProdi = User::where('unit_id', $user->unit_id)
            ->where('jabatan_id', 2)
            ->first();
        if (!$ketuaProdi) {
            return redirect()->back()->withErrors(['unit_id' => 'Ketua Prodi tidak ditemukan untuk unit ini.'])->withInput();
        }

        $emailKetuaProdi = $ketuaProdi->email;
        if (empty($emailKetuaProdi)) {
            return redirect()->back()->withErrors(['email' => 'Email Ketua Prodi tidak ditemukan.'])->withInput();
        }

        $validatedData = $validator->validated();

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
        if ($filePath) {
            $perizinan->bukti = $filePath;
        }
        $perizinan->status = 'Diproses';
        $perizinan->save();

        // Mengirim email
        $details = [
            'nama' => $validatedData['nama'],
            'nip' => $validatedData['nip'],
            'pangkat_jabatan' => $validatedData['pangkat_jabatan'],
            'jabatan' => $validatedData['jabatan'],
            'unit_kerja' => $validatedData['unit_kerja'],
            'jenis_izin' => $validatedData['jenis_izin'],
            'waktu' => $validatedData['waktu'],
            'alasan' => $validatedData['alasan']
        ];

        Mail::to($emailKetuaProdi)->send(new IzinDiajukan($details));

        return redirect()->back()->with('success', 'Permohonan izin berhasil diajukan.');
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

    public function data_permohonan_wadir1()
    {
        //mengambil data sesuai kepala jurusan
        $perizinan = ModelsPerizinan::where('jabatan', 'Ketua Jurusan')->get();

        return view('wadir.data_permohonan', compact('perizinan'));
    }

    public function data_permohonan_wadir2()
    {
        // Mengambil data sesuai status disetujui
        $perizinan = ModelsPerizinan::where('status', 'Pending')->get();

        return view('wadir.data_permohonanWd2', compact('perizinan'));
    }


    public function editRespon(Request $request, $id)
    {
        $perizinan = ModelsPerizinan::findOrFail($id);
        $perizinan->status = $request->input('status');
        $perizinan->save();

        $wadir = User::where('jabatan_id', 5)->first();
        $emailwadir = $wadir->email;

        // Mengirim email
        $details = [
            'nama' => $perizinan->user->name,
            'nip' => $perizinan->user->nip,
            'pangkat_jabatan' => $perizinan->user->pangkat_jabatan->name,
            'jabatan' => $perizinan->user->jabatan->name,
            'unit_kerja' => $perizinan->user->unit->name,
            'jenis_izin' => $perizinan->jenis_izin,
            'waktu' => $perizinan->waktu,
            'alasan' => $perizinan->alasan
        ];
        Mail::to($emailwadir)->send(new IzinDiajukan($details));
        return redirect()->back()->with('success', 'status berhasil diupdate.');
    }

    public function tolakizin(Request $request, $id)
    {
        $perizinan = ModelsPerizinan::findOrFail($id);
        $perizinan->status = $request->input('status');
        $perizinan->save();
        return redirect()->back()->with('success', 'status berhasil diupdate.');
    }

    public function editResponwd(Request $request, $id)
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
            'bukti' => 'nullable|file|mimes:png,jpg,jpeg|max:5120', // Tambahkan batas maksimal ukuran file 5MB
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

    public function pembatalan($id)
    {
        $perizinan = ModelsPerizinan::findOrFail($id);
        $perizinan = ModelsPerizinan::where('id', $id)->update(['status' => 'Dibatalkan']);
        return redirect()->back()->with('success', 'Data perizinan berhasil dibatalkan.');
    }
}
