<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('auth_user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'auth_user_id' => $user->id,
            'auth_user_name' => $user->name,
            'auth_user_email' => $user->email,
            'auth_user_role' => $user->role,
        ]);

        return redirect()->intended(route('dashboard'))->with('success', 'Login berhasil. Selamat datang, '.$user->name.'.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'auth_user_id',
            'auth_user_name',
            'auth_user_email',
            'auth_user_role',
        ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
