<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Cek jika input form berupa email atau username/NIM
        $loginField = filter_var($request->identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $authData = [
            $loginField => $request->identity,
            'password'  => $request->password
        ];

        if (Auth::attempt($authData, $request->has('remember'))) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Autentikasi berhasil! Mengalihkan ke Panel Admin...'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'NIM/Email atau Kata Sandi yang Anda masukkan salah.'
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
