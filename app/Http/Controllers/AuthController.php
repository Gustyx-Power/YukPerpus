<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect ke panel yang sesuai
            if ($user->level === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->level === 'petugas') {
                return redirect('/petugas/dashboard');
            } else {
                return redirect('/user/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan form registrasi
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $filename = Str::random(20) . '.' . $request->foto->extension();
            $path = $request->foto->storeAs('public/profiles', $filename);
            $data['foto'] = 'profiles/' . $filename;
        }

        $user = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'level' => 'anggota', // Default level
            'foto' => $data['foto'] ?? null,
        ]);

        Auth::login($user);

        return redirect('/member/dashboard')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Menampilkan profil user
     */
    public function profile()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    /**
     * Update profil user
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Update password jika diisi
        if (!empty($data['new_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah']);
            }
            $user->password = Hash::make($data['new_password']);
        }

        // Handle upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }

            $filename = Str::random(20) . '.' . $request->foto->extension();
            $path = $request->foto->storeAs('public/profiles', $filename);
            $user->foto = 'profiles/' . $filename;
        }

        $user->nama = $data['nama'];
        $user->email = $data['email'];
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
