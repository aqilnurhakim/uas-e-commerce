<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->session()->get('auth_user_id');

        if (! $userId) {
            $request->session()->put('url.intended', $request->fullUrl());

            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses aplikasi.');
        }

        $user = User::find($userId);

        if (! $user) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        view()->share('currentUser', $user);
        $request->attributes->set('current_user', $user);

        return $next($request);
    }
}
