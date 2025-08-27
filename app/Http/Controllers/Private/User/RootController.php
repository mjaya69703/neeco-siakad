<?php

namespace App\Http\Controllers\Private\User;

use App\Http\Controllers\Controller;
// Use Systems
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Private\UpdateProfileRequest;
use App\Services\Private\UpdateProfileService;
// Use Plugins
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Pengaturan\Kampus;
use App\Models\Pengaturan\System;
use App\Models\Referensi\Agama;
use App\Models\Referensi\GolonganDarah;
use App\Models\Referensi\JenisKelamin;
use App\Models\Referensi\Kewarganegaraan;

class RootController extends Controller
{
    public function renderDashboard()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Dashboard';
        $data['pages'] = "HomePage";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        return view('default-bcontent', $data, compact('user'));
    }

    public function renderProfile()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Profile';
        $data['pages'] = "Halaman Profile" ;
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        // Models
        $data['jenisKelamins'] = JenisKelamin::all();
        $data['agamas'] = Agama::all();
        $data['kewarganegaraans'] = Kewarganegaraan::all();
        $data['golonganDarahs'] = GolonganDarah::all();

        return view('private.profile-index', $data, compact('user'));
    }

    public function handleProfile(UpdateProfileRequest $request, UpdateProfileService $service)
    {
        try {
            $service->updateProfile($request->validated());
            
            Alert::toast('Profil berhasil diperbarui', 'success');
            return redirect()->back();
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Profile update error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            
            Alert::error('Error', 'Gagal memperbarui profil: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

}
