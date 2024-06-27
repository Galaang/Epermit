<?php

namespace App\Http\Controllers;

use App\Models\perizinan as ModelsPerizinan;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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
        $user = Auth::user();

        $jenisUnit = $user->unit_id;
        $jabatanId = $user->jabatan_id;

        // Mendefinisikan array untuk jenis jabatan yang ingin diambil
        $jabatanIds = [];

        // Menentukan jabatan-jabatan yang sesuai berdasarkan jabatan pengguna
        if ($jabatanId == 1) { // Misalnya ID 1 adalah dosen
            $jabatanIds = [1, 2]; // Dosen dan kaprodi
        } elseif ($jabatanId == 2) { // Misalnya ID 2 adalah kaprodi
            $jabatanIds = [2, 3]; // Kaprodi dan kajur
        } else {
            $jabatanIds = [$jabatanId];
        }

        // Mengambil perizinan yang sesuai dengan jenis jabatan pengguna yang sedang login
        $perizinan = ModelsPerizinan::join('users', 'users.id', '=', 'perizinans.user_id')
            ->where('users.unit_id', $jenisUnit)
            ->whereIn('users.jabatan_id', $jabatanIds)
            ->select('perizinans.*')
            ->paginate(15);

        return view('data_permohonan', compact('perizinan'));
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
            'alasan' => 'required|string'
        ]);

        // Set waktu ke null jika jenis izin adalah 'Tidak Masuk Kerja'
        $jenis_izin = $request->input('jenis_izin');
        if ($jenis_izin === 'Tidak Masuk Kerja') {
            $waktu = null;
        } else {
            // Jika jenis izin bukan 'Tidak Masuk Kerja', ambil waktu dari input
            $waktu = $request->input('waktu');
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
