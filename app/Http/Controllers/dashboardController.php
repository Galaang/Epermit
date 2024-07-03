<?php

namespace App\Http\Controllers;

use App\Models\perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        $perizinan = perizinan::where('user_id', $user->id)->get();

        // total permohonan perizinan
        $total_perizinan = perizinan::where('user_id', $user->id)->count();

        // total permohonan perizinan disetujui
        $perizinan_disetujui = perizinan::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->count();

        // total permohonan perizinan ditolak
        $perizinan_ditolak = perizinan::where('user_id', $user->id)
            ->where('status', 'Ditolak')
            ->count();

        return view('index', compact('perizinan', 'total_perizinan', 'perizinan_disetujui', 'perizinan_ditolak'));
    }
}
