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
        return view('index' , compact('perizinan'));
    }
}
