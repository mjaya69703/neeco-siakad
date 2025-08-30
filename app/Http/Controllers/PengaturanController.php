<?php

namespace App\Http\Controllers;
// Use Systems
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
// Use Models
use App\Models\Pengaturan\Kampus;
use App\Models\Pengaturan\System;
// Use Request & Service
use App\Http\Requests\UpdatePengaturanRequest;
use App\Services\UpdatePengaturanService;

class PengaturanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "HomePage";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        return view('pengaturan-index', $data, compact('user'));
    }
    
    public function update(UpdatePengaturanRequest $request)
    {
        try {
            $service = new UpdatePengaturanService();
            $result = $service->update($request->validated());

            if ($result) {
                return redirect()->route('pengaturan-index')
                    ->with('success', 'Pengaturan berhasil diperbarui.');
            }

            return redirect()->route('pengaturan-index')
                ->with('error', 'Gagal memperbarui pengaturan. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return redirect()->route('pengaturan-index')
                ->with('error', 'Terjadi kesalahan saat memperbarui pengaturan: ' . $e->getMessage());
        }
    }
}
