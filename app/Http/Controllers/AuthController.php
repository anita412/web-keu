<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        // Jika user sudah login tapi coba buka halaman login lagi, lempar ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tambahkan fitur 'remember' agar session tidak cepat habis
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // intended() sangat penting agar user kembali ke halaman yang mereka klik sebelumnya
            return redirect()->intended('/dashboard');
        }

        // WAJIB: Jika gagal, harus dikembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}