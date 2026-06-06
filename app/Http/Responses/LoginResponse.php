<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Ambil data user yang baru saja berhasil login
        $user = Auth::user();

        // Cek role user dan alihkan ke halaman yang sesuai
       if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
}