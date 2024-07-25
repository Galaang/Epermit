<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\jabatan;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\perizinan;
use App\Models\Unit_kerja;
use Illuminate\Http\Request;
use App\Models\pangkat_jabatan;
use Illuminate\Support\Facades\Hash;

class pegawaiController extends Controller
{
    //tampilan pegawai
    public function pegawai()
    {
        $pegawai = User::all();
        $pangkat = pangkat_jabatan::all();
        $unit = Unit_kerja::all();
        $jabatan = jabatan::all();
        return view('baup.pegawai', compact('pangkat', 'unit', 'pegawai', 'jabatan'));
    }

    // tambah pegawai
    public function tambahPegawai(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'pangkat_jabatan_id' => 'required',
            'jabatan_id' => 'required',
            'unit_id' => 'required',
        ], [
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIP yang berbeda.',
        ]);

        

        // Menentukan role berdasarkan jabatan_id
        $role = 0; // nilai awal
        if ($request->jabatan_id == 1) {
            $role = 1;
        } elseif ($request->jabatan_id == 2) {
            $role = 2;
        } elseif ($request->jabatan_id == 3) {
            $role = 2;
        } elseif ($request->jabatan_id == 4) {
            $role = 3;
        } elseif ($request->jabatan_id == 5) {
            $role = 3;
        } else {
            $role = 1;
        }

        // Menyimpan data pegawai baru
        $pegawai = new User();
        $pegawai->role_id = $role;
        $pegawai->name = $request->name;
        $pegawai->nip = $request->nip;
        $pegawai->pangkat_jabatan_id = $request->pangkat_jabatan_id;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->unit_id = $request->unit_id;
        $pegawai->password = Hash::make($request->nip);

        $pegawai->save();

        return redirect()->route('pegawai')->with('success', 'Pegawai baru ditambahkan');
    }

    // hapus pegawai
    public function hapusPegawai($id)
    {
        // Temukan pegawai berdasarkan ID
        $pegawai = User::find($id);

        if ($pegawai) {
            // Hapus data perizinan yang berhubungan dengan pegawai
            perizinan::where('user_id', $pegawai->id)->delete();

            // Hapus pegawai
            $pegawai->delete();

            return redirect()->route('pegawai')->with('success', 'Pegawai dan data terkait dihapus');
        } else {
            return redirect()->route('pegawai')->with('error', 'Pegawai tidak ditemukan');
        }
    }

    public function editPegawai(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'nip' => 'required',
            'pangkat_jabatan_id' => 'required|exists:pangkat_jabatans,id', // Validasi pangkat_jabatan_id
            'jabatan_id' => 'required|exists:jabatans,id', // Validasi jabatan_id
            'unit_id' => 'required',
        ]);

        // Temukan pegawai berdasarkan ID
        $pegawai = User::find($id);

        if ($pegawai) {
            // Perbarui data pegawai
            $pegawai->name = $request->name;
            $pegawai->nip = $request->nip;
            $pegawai->pangkat_jabatan_id = $request->pangkat_jabatan_id;
            $pegawai->jabatan_id = $request->jabatan_id;
            $pegawai->unit_id = $request->unit_id;

            $pegawai->save();

            // Dapatkan nama pangkat jabatan dan jabatan
            $pangkatJabatan = pangkat_jabatan::find($request->pangkat_jabatan_id);
            $jabatan = jabatan::find($request->jabatan_id);
            $unit = Unit_kerja::find($request->unit_id);

            // Perbarui laporan yang berhubungan dengan pegawai ini
            perizinan::where('user_id', $pegawai->id)->update([
                'nama' => $request->name,
                'nip' => $request->nip,
                'pangkat_jabatan' => $pangkatJabatan->name,
                'jabatan' => $jabatan->name,
                'unit_kerja' => $unit->name,
            ]);

            return redirect()->route('pegawai')->with('success', 'Pegawai dan laporan terkait berhasil diubah');
        } else {
            return redirect()->route('pegawai')->with('error', 'Pegawai tidak ditemukan');
        }
    }


    public function unitKerja()
    {
        $unit = Unit_kerja::all();
        return view('baup.unitKerja', compact('unit'));
    }

    //tambah unit kerja
    public function tambahUnitKerja(Request $request)
    {
        $unit = new Unit_kerja();
        $unit->name = $request->name;
        $unit->save();
        return redirect()->route('unit-kerja')->with('success', 'Unit kerja baru ditambahkan');
    }

    public function editUnitKerja(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        // Cek apakah unit kerja dengan ID yang diberikan ada
        $unit = Unit_kerja::find($id);
        if (!$unit) {
            return redirect()->route('unit-kerja')->with('error', 'Unit kerja tidak ditemukan');
        }

        // Ubah data unit kerja
        $unit->name = $request->name;

        // Simpan perubahan dan tangani kemungkinan error
        try {
            $unit->save();
            return redirect()->route('unit-kerja')->with('success', 'Unit kerja berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('unit-kerja')->with('error', 'Terjadi kesalahan saat mengubah unit kerja: ' . $e->getMessage());
        }
    }


    public function pangkatJabatan()
    {
        $pangkat = pangkat_jabatan::all();
        return view('baup.pangkatJabatan', compact('pangkat'));
    }

    //tambah pangkat jabatan
    public function tambahPangkatJabatan(Request $request)
    {
        $pangkat = new pangkat_jabatan();
        $pangkat->name = $request->name;
        $pangkat->save();
        return redirect()->route('pangkat-jabatan')->with('success', 'Pangkat jabatan baru ditambahkan');
    }

    //hapus pangkat jabatan
    public function hapusPangkatJabatan($id)
    {
        $pangkat = pangkat_jabatan::find($id);
        $pangkat->delete();
        return redirect()->route('pangkat-jabatan')->with('success', 'Pangkat jabatan dihapus');
    }

    // edit pangkat jabatan
    public function editPangkatJabatan(Request $request, $id)
    {
        $pangkat = pangkat_jabatan::find($id);
        $pangkat->name = $request->name;
        $pangkat->save();
        return redirect()->route('pangkat-jabatan')->with('success', 'Pangkat jabatan diubah');
    }

    public function jabatan()
    {
        $jabatan = jabatan::all();
        return view('baup.jabatan', compact('jabatan'));
    }

    public function tambahJabatan(Request $request)
    {
        $jabatan = new jabatan();
        $jabatan->name = $request->name;
        $jabatan->save();
        return redirect()->route('jabatan')->with('success', 'Jabatan baru ditambahkan');
    }

    public function editJabatan(Request $request, $id)
    {
        $jabatan = jabatan::find($id);
        $jabatan->name = $request->name;
        $jabatan->save();
        return redirect()->route('jabatan')->with('success', 'Jabatan berhasil diubah');
    }

    public function cetak()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $perizinan = Perizinan::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('baup.formPdf', ['perizinan' => $perizinan]);
        return $pdf->stream('laporan_perizinan.pdf');
    }
}
