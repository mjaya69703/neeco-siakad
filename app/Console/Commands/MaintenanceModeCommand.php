<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pengaturan\System;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MaintenanceModeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:maintenance-mode {status : Status maintenance mode (on/off)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengaktifkan atau menonaktifkan mode maintenance aplikasi dengan file Laravel standar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $status = $this->argument('status');
        
        if (!in_array($status, ['on', 'off'])) {
            $this->error('Status tidak valid. Gunakan "on" atau "off".');
            return 1;
        }
        
        try {
            // Update database setting
            $system = System::first();
            
            if (!$system) {
                $this->error('Data pengaturan sistem tidak ditemukan.');
                return 1;
            }
            
            $system->maintenance_mode = ($status === 'on');
            $system->save();
            
            // Handle maintenance mode
            if ($status === 'on') {
                // Generate random access code for bypass
                $accessCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
                
                // Buat file maintenance dengan kode akses
                $maintenanceFilePath = storage_path('framework/maintenance');
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
                
                $this->info('Mode maintenance berhasil diaktifkan.');
                $this->line('\n<fg=yellow;bg=black>KODE AKSES MAINTENANCE: ' . $accessCode . '</>');
                $this->line('<fg=yellow;bg=black>Gunakan kode ini untuk mengakses website selama mode maintenance aktif.</>');
                
                // Log access code
                Log::info('Maintenance mode activated with access code: ' . $accessCode);
            } else {
                // Hapus file maintenance jika ada
                $maintenanceFilePath = storage_path('framework/maintenance');
                if (File::exists($maintenanceFilePath)) {
                    File::delete($maintenanceFilePath);
                }
                
                $this->info('Mode maintenance berhasil dinonaktifkan.');
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::error('Error toggling maintenance mode: ' . $e->getMessage());
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            return 1;
        }
    }
}