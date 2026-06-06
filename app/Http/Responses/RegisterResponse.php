<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        // 1. Log out user yang baru saja otomatis login oleh Jetstream
        Auth::logout();

        // 2. Bersihkan session lama agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Alihkan ke halaman login dengan membawa pesan sukses
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan masuk menggunakan akun Anda.');
    }
}