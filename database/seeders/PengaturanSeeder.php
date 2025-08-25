<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pengaturan\System::create([
            'app_name' => 'Neco Siakad',
            'app_version' => 'under development',
            'app_description' => 'Sistem Informasi Akademik Open Source',
            'app_url' => 'https://neco-siakad.idev-fun.org',
            'app_email' => 'info@idev-fun.org',
            
            // Pengaturan Logo
            'app_favicon' => 'favicon.png',
            'app_logo_vertikal' => 'logo-vertikal.png',
            'app_logo_horizontal' => 'logo-horizontal.png',

            // Pengaturan Khusus
            'maintenance_mode' => false,
            'enable_captcha' => false,
            'max_login_attempts' => 5,
            'login_decay_seconds' => 300,
        ]);

        \App\Models\Pengaturan\Kampus::create([
            'name' => 'Nusantara Academy Center',
            'phone' => '081200000001',
            'faximile' => '081200000002',
            'whatsapp' => '081200000003',
            'email_info' => 'info@idev-fun.org',
            'email_humas' => 'humas@idev-fun.org',
            'domain' => 'idev-fun.org',
            // Logo Kampus
            'favicon' => 'favicon.png',
            'logo_vertikal' => 'logo-vertikal.png',
            'logo_horizontal' => 'logo-horizontal.png',
            // Alamat Institusi
            'alamat' => 'Jl. Pendidikan No. 123, Kompleks Akademik',
            'kelurahan' => 'Suka Maju',
            'kecamatan' => 'Cikarang Utara',
            'kota_kabupaten' => 'Bekasi',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '17530',
            'rt' => '001',
            'rw' => '005',
            'langtitude' => '-6.234567',
            'longitude' => '106.789012',
            // Sosial Media
            'tiktok' => '@nusantaraacademy',
            'linkedin' => 'nusantara-academy-center',
            'xtwitter' => '@nusantara_edu',
            'facebook' => 'NusantaraAcademyCenter',
            'instagram' => '@nusantara.academy',
        ]);
    }
}
