<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            Log::info('Auth login: user id='.$user->id.' email='.$user->email.' role='.(isset($user->role)?$user->role:'(null)'));

            // Si el id del usuario es 2, forzamos redirección a /solicitud
            if (isset($user->id) && (int) $user->id === 2) {
                return redirect()->to('/solicitud');
            }

            $role = isset($user->role) ? (int) $user->role : 0;

            if ($role === 1) {
                return redirect()->to('/solicitud');
            }

            if ($role === 2) {
                return redirect()->to('/admin');
            }

            return redirect()->to('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
