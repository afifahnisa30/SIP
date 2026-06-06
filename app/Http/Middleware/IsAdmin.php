<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Gunakan method 'has' atau pengecekan manual untuk menghindari error properti
        $user = auth()->user();

        if ($user && isset($user->role) && $user->role === 'admin') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses admin!');
    }
}