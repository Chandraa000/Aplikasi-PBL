<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $roleHint = $request->input('role_hint', 'mahasiswa');

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek role sesuai tab yang dipilih
            if ($roleHint == 'dospem' && $user->role !== 'dospem') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan Dosen Pembimbing.',
                ])->withInput();
            }

            if ($roleHint == 'mahasiswa' && $user->role !== 'mahasiswa') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan Mahasiswa.',
                ])->withInput();
            }

            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }
}