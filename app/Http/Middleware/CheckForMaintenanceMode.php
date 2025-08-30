<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah mode maintenance aktif dari database atau dari parameter URL
        $system = System::first();
        $kampus = Kampus::first();
        
        // Jika ada parameter maintenance=true dari redirect maintenance.php
        $maintenanceParam = $request->query('maintenance');
        
        if (($system && $system->maintenance_mode) || $maintenanceParam === 'true') {
            // Jika user adalah admin, bypass maintenance mode
            $user = Auth::user();
            if ($user && $user->is_admin) {
                return $next($request);
            }
            
            // Cek kode akses dari cookie atau parameter URL
            $accessCodeFromCookie = $request->cookie('maintenance_access');
            $accessCodeFromUrl = $request->query('access_code');
            
            // Ambil kode akses dari file maintenance
            $maintenanceFilePath = storage_path('framework/maintenance');
            $secretCode = null;
            
            if (File::exists($maintenanceFilePath)) {
                $maintenanceData = json_decode(File::get($maintenanceFilePath), true);
                $secretCode = $maintenanceData['secret'] ?? null;
            } else {
                // Jika file maintenance tidak ada, buat file dengan kode akses default
                // Ini untuk memastikan kode akses tersedia meskipun file belum dibuat oleh command
                if ($system->maintenance_mode) {
                    $accessCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
                    $payload = json_encode([
                        'time' => time(),
                        'message' => 'Sistem sedang dalam pemeliharaan',
                        'retry' => 60,
                        'secret' => $accessCode,
                        'allowed' => []
                    ]);
                    
                    // Pastikan direktori framework ada
                    if (!File::exists(storage_path('framework'))) {
                        File::makeDirectory(storage_path('framework'), 0755, true);
                    }
                    
                    File::put($maintenanceFilePath, $payload);
                    $secretCode = $accessCode;
                }
            }
            
            // Jika kode akses valid, bypass maintenance mode dan set cookie
            if ($secretCode && ($accessCodeFromCookie === $secretCode || $accessCodeFromUrl === $secretCode)) {
                $response = $next($request);
                
                // Jika kode akses dari URL valid, set cookie untuk akses selanjutnya
                if ($accessCodeFromUrl === $secretCode && !$accessCodeFromCookie) {
                    $response->cookie('maintenance_access', $secretCode, 60 * 24); // Cookie berlaku 24 jam
                }
                
                return $response;
            }
            
            // Jika bukan admin dan tidak memiliki kode akses valid, tampilkan halaman maintenance
            return response()->view('errors.maintenance', ['system' => $system, 'kampus' => $kampus], 503);
        }
        
        return $next($request);
    }
}