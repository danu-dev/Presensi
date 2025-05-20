<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            return redirect("/$role/dashboard")->with('success', 'Login berhasil!');
        }

        // Jika login gagal, beri pesan spesifik
        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input dengan pesan kustom
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];

        $messages = [
            'name.required'      => 'Nama wajib diisi.',
            'name.string'        => 'Nama harus berupa teks.',
            'name.max'           => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];

                                                 // Conditionally validate nisn for 'user' role
        $role = $request->input('role', 'user'); // Default to 'user' if no role is provided
        if ($role === 'user') {
            $rules['nisn']             = 'required|string|unique:users,nisn|digits:10';
            $messages['nisn.required'] = 'NISN wajib diisi untuk siswa.';
            $messages['nisn.string']   = 'NISN harus berupa teks.';
            $messages['nisn.unique']   = 'NISN sudah terdaftar.';
            $messages['nisn.digits']   = 'NISN harus terdiri dari 10 digit.';
        } else {
            $rules['nisn']           = 'nullable|string|unique:users,nisn|digits:10';
            $messages['nisn.string'] = 'NISN harus berupa teks.';
            $messages['nisn.unique'] = 'NISN sudah terdaftar.';
            $messages['nisn.digits'] = 'NISN harus terdiri dari 10 digit.';
        }

        $request->validate($rules, $messages);

        // Buat pengguna baru
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nisn'     => $request->nisn, // Will be null for non-user roles if not provided
            'password' => bcrypt($request->password),
            'role'     => $role,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout berhasil.');
    }
}
