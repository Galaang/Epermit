<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Auth_controller extends Controller
{
    public function loginview()
    {
        return view('signin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('nip', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'nip' => 'NIP atau Password yang anda masukkan salah.',
        ])->withInput($request->only('nip'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function editProfile(Request $request)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' .  $user->id,
            'nip' => 'required|numeric',
            'password_lama' => 'nullable|string',
            'password_baru' => 'nullable|string|confirmed',
        ]);
        // dd($request);

        // Verifikasi password jika ada perubahan password
        // if ($request->password_lama && $request->password_baru) {
        //     if (!Hash::check($request->password_lama, $user->password)) {
        //         return back()->with('error', 'Password lama yang Anda masukkan salah.');
        //     }
        //     $user->password = Hash::make($request->password_baru);
        // }

        if ($request->password_lama && $request->password_baru) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->with('error', 'Password lama yang Anda masukkan salah.');
            }
            $user->password = Hash::make($request->password_baru);
        }

        // Mengupdate data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;

        // Tambahkan field lain yang ingin diupdate
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
