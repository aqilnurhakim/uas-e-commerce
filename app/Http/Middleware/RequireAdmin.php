<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('auth_user_role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Fitur ini hanya dapat digunakan oleh admin.');
        }

        return $next($request);
    }
}
