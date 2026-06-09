<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user')) {
            return redirect()->route('buku.index');
        }

        return view('auth.login');
    }

    /**
     * Proses login: validasi input, cek database, simpan session.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
            ]]);

            return redirect()->route('buku.index')
                ->with('success', 'Selamat datang, ' . $user->username . '!');
        }

        // Login gagal: kembali ke form dengan pesan error
        return back()
            ->withErrors(['login' => 'Email atau password salah.'])
            ->withInput(['email' => $request->email]);
    }

    /**
     * Proses logout: hapus session dan redirect ke login.
     */
    public function logout(Request $request)
    {
        session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
