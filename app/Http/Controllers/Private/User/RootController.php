<?php

namespace App\Http\Controllers\Private\User;

use App\Http\Controllers\Controller;
// Use Systems
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Private\profileRequest;
use App\Services\Private\profileService;
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
        $data['menus'] = 'Dashboard';
        $data['pages'] = "HomePage";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        // Models
        $data['jenisKelamins'] = JenisKelamin::all();
        $data['agamas'] = Agama::all();
        $data['kewarganegaraans'] = Kewarganegaraan::all();
        $data['golonganDarahs'] = GolonganDarah::all();

        return view('private.profile-index', $data, compact('user'));
    }

    public function handleProfile(profileRequest $request, profileService $service)
    {
        $user = Auth::user();
        $result = $service->updateProfile($user, $request->validated());
        
        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }
        
        return redirect()->back()->withErrors($result['message'])->withInput();
    }

    /**
     * Delete education record
     */
    public function deletePendidikan($id, profileService $service)
    {
        $user = Auth::user();
        $result = $service->deleteEducation($id, $user->id);
        
        if ($result['success']) {
            return response()->json(['message' => $result['message']], 200);
        }
        
        return response()->json(['message' => $result['message']], 400);
    }

    /**
     * Delete family record
     */
    public function deleteKeluarga($id, profileService $service)
    {
        $user = Auth::user();
        $result = $service->deleteFamily($id, $user->id);
        
        if ($result['success']) {
            return response()->json(['message' => $result['message']], 200);
        }
        
        return response()->json(['message' => $result['message']], 400);
    }
}
