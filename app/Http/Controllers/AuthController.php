<?php

namespace App\Http\Controllers;

// Use Systems
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
// Use Models
use App\Models\Pengaturan\Kampus;
use App\Models\Pengaturan\System;
use App\Models\User;
// Use Plugins
use RealRashid\SweetAlert\Facades\Alert;


class AuthController extends Controller
{
    public function renderSignin()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "HomePage";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        return view('themes.auth.auth-signin', $data, compact('user'));
    }

        public function handleSignin(Request $request)
    {
        try {
            $request->validate([
                'login' => 'required',
                'password' => 'required',
            ]);
    
            $login = $request->input('login');
    
            // ==== RATE LIMIT ====
            $pengaturan = System::first();
            $maxAttempts = $pengaturan->max_login_attempts ?? 5;
            $decaySeconds = $pengaturan->login_decay_seconds ?? 60;
            $key = 'login:'.Str::lower($login).'|'.$request->ip();
    
            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                $seconds = RateLimiter::availableIn($key);
                Alert::error('Terlalu banyak percobaan', "Coba lagi dalam {$seconds} detik.");
                return back()
                    ->withErrors(['login' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."])
                    ->onlyInput('login');
            }
    
            // Cek login input
            $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
            $checkUser = User::where($fieldType, $login)->first();
            // $checkMahasiswa = Mahasiswa::where($fieldType, $login)->first();
            // $checkDosen = Dosen::where($fieldType, $login)->first();

            if ($checkUser) {
                if (Auth::attempt([$fieldType => $login, 'password' => $request->input('password')])) {
                    if (Auth::user()->prefix === Auth::user()->prefix) {
                        Alert::toast('Kamu telah berhasil login sebagai ' . Auth::user()->name, 'success');
                        return redirect()->route('dashboard-index');
                    }
    
                } else {
                    RateLimiter::hit($key, $decaySeconds);
                    Alert::error('Error', 'Mohon Maaf, Username / Email atau password salah');
                    return back();
                }

            } else {
                Alert::error('Error', 'Mohon Maaf, Akun anda tidak terdaftar pada system kami.');
                return back();
            }
    
        } catch (\Throwable $e) {
            // Log error untuk debugging
            \Log::error('Login error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
    
            // Tampilkan pesan error user-friendly
            Alert::error('Error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            return back();
        }
    }
    
    public function handleLogout(Request $request) {
        if (Auth::check()) {

            Auth::logout();
            Alert::success('Berhasil!', 'Logout telah sukses!');
            return redirect()->route('auth.render-signin');
        } else {

            Alert::error('Gagal!', 'Logout gagal, Silahkan coba lagi!');
            return back();
        }
    }
}
