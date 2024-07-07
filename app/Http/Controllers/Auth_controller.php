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
        // dd($request->all());
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' .  $user->id,
            'nip' => 'required|numeric',
            'password_lama' => 'nullable|string',
            'password_baru' => 'nullable|string',
        ]);

        // Memeriksa apakah password lama benar
        if (!is_null($request->password_lama) && !Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama yang Anda masukkan salah.'])->withInput();
        }

        // Memeriksa apakah password baru benar
        if (!is_null($request->password_baru) && $request->password_baru === $request->password_lama) {
            return back()->withErrors(['password_baru' => 'Password baru yang Anda masukkan sama dengan password lama.'])->withInput();
        }

        if (!is_null($request->password_baru)) {
            $user->password = Hash::make($request->password_baru);
        }


        // Mengupdate data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
