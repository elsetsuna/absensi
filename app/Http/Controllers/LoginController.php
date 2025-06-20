<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    public function signup(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string'],
            'agama' => ['required', 'string'],
            'bo' => ['required', 'string'],
            'jabatan' => ['required', 'string'],
            // Add other validation rules as needed
        ]);
        // Check if the user already exists
        if (User::where('username', $request->username)->exists()) {
            return redirect()->back()->withErrors(['username' => 'Username already exists.']);
        }
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email already exists.']);
        }
        
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->nama = $request->nama;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->agama = $request->agama;
        $user->bo = $request->bo;
        $user->jabatan = $request->jabatan;
        $user->tanggal_masuk_kerja = $request->tanggal_masuk_kerja;
        $user->status = 'Aktif'; // Default status
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        // dd($user);

        return redirect()->route('signin')->with('success', 'Registration successful. Please log in.');
    }
}