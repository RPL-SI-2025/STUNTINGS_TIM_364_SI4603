<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_anak' => 'required',
            'nik_anak' => 'required|digits:16|unique:users,nik_anak',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'nama_anak' => $request->nama_anak,
            'nik_anak' => $request->nik_anak,
            'password' => Hash::make($request->password),
            'role' => 'orangtua', 
        ]);

        return redirect('/login')->with('success', 'Register berhasil, silakan login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('nik_anak', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Jika ingin pakai role:
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'orangtua') {
                return redirect()->route('orangtua.dashboard');
            } else {
                Auth::logout();
                return redirect('/login')->with('error', 'Role tidak dikenali');
            }
            
        }

        return back()->withErrors([
            'login' => 'NIK atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
