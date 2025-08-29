<?php

namespace App\Http\Controllers;

// Use Systems
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Use Models
use App\Models\Pengaturan\Kampus;
use App\Models\Pengaturan\System;
use App\Models\Referensi\Agama;
use App\Models\Referensi\GolonganDarah;
use App\Models\Referensi\JenisKelamin;
use App\Models\Referensi\Kewarganegaraan;
use App\Models\Referensi\Jabatan;
use App\Models\Referensi\Semester;
use App\Models\Referensi\StatusMahasiswa;
use App\Models\Referensi\Role;
use App\Models\Referensi\Alamat;
use App\Models\Referensi\Pendidikan;
use App\Models\Referensi\Keluarga;
use App\Models\User;


class RootController extends Controller
{
    public function renderHomePage()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "HomePage";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        return view('default-content', $data, compact('user'));
    }

    public function indexReferensi()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "Dashboard Referensi";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        // Get reference data counts and statistics
        $data['stats'] = [
            'agama' => Agama::count(),
            'golongan_darah' => GolonganDarah::count(),
            'jenis_kelamin' => JenisKelamin::count(),
            'kewarganegaraan' => Kewarganegaraan::count(),
            'jabatan' => Jabatan::count(),
            'semester' => Semester::count(),
            'status_mahasiswa' => StatusMahasiswa::count(),
            'role' => Role::count(),
            'alamat' => Alamat::count(),
            'pendidikan' => Pendidikan::count(),
            'keluarga' => Keluarga::count(),
            'total_users' => User::count()
        ];

        // Get sample data for each reference type
        $data['sample_data'] = [
            'agamas' => Agama::orderBy('name')->get(),
            'golongan_darahs' => GolonganDarah::orderBy('name')->get(),
            'jenis_kelamins' => JenisKelamin::orderBy('name')->get(),
            'kewarganegaraans' => Kewarganegaraan::orderBy('name')->get(),
            'jabatans' => Jabatan::orderBy('name')->get(),
            'semesters' => Semester::orderBy('name')->get(),
            'status_mahasiswas' => StatusMahasiswa::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ];

        // Get recent activities (limited sample)
        $data['recent_alamats'] = Alamat::with('owner')
            ->latest()
            ->limit(5)
            ->get();
        
        $data['recent_pendidikans'] = Pendidikan::with('owner')
            ->latest()
            ->limit(5)
            ->get();
        
        $data['recent_keluargas'] = Keluarga::with('owner')
            ->latest()
            ->limit(5)
            ->get();

        // User distribution by reference data (only for models with proper relationships)
        $data['user_distribution'] = [
            'by_agama' => User::selectRaw('agama_id, count(*) as total')
                ->whereNotNull('agama_id')
                ->groupBy('agama_id')
                ->with('agama')
                ->get(),
            'by_jenis_kelamin' => User::selectRaw('jenis_kelamin_id, count(*) as total')
                ->whereNotNull('jenis_kelamin_id')
                ->groupBy('jenis_kelamin_id')
                ->with('jenisKelamin')
                ->get(),
            'by_golongan_darah' => User::selectRaw('golongan_darah_id, count(*) as total')
                ->whereNotNull('golongan_darah_id')
                ->groupBy('golongan_darah_id')
                ->with('golonganDarah')
                ->get(),
            'by_kewarganegaraan' => User::selectRaw('kewarganegaraan_id, count(*) as total')
                ->whereNotNull('kewarganegaraan_id')
                ->groupBy('kewarganegaraan_id')
                ->with('kewarganegaraan')
                ->get()
        ];

        return view('referensi.referensi-index', $data, compact('user'));
    }
}
