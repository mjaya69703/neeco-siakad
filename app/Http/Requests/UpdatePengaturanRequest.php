<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengaturanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assuming authorization is handled via middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // Aplikasi
            'app_name' => 'required|string|max:255',
            'app_version' => 'nullable|string|max:50',
            'app_description' => 'nullable|string|max:1000',
            'app_url' => 'nullable|string|max:255',
            'app_email' => 'nullable|email|max:255',
            
            // Kampus
            'kampus_name' => 'required|string|max:255',
            'kampus_domain' => 'nullable|string|max:255',
            'kampus_phone' => 'nullable|string|max:20',
            'kampus_faximile' => 'nullable|string|max:20',
            'kampus_whatsapp' => 'nullable|string|max:20',
            'kampus_email_info' => 'nullable|email|max:255',
            'kampus_email_humas' => 'nullable|email|max:255',
            
            // Logo & Favicon
            'app_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
            'app_logo_vertikal' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_logo_horizontal' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
            // Alamat
            'kampus_alamat' => 'nullable|string|max:500',
            'kampus_rt' => 'nullable|string|max:10',
            'kampus_rw' => 'nullable|string|max:10',
            'kampus_kelurahan' => 'nullable|string|max:100',
            'kampus_kecamatan' => 'nullable|string|max:100',
            'kampus_kota_kabupaten' => 'nullable|string|max:100',
            'kampus_provinsi' => 'nullable|string|max:100',
            'kampus_kode_pos' => 'nullable|string|max:10',
            'kampus_langtitude' => 'nullable|string|max:50',
            'kampus_longitude' => 'nullable|string|max:50',
            
            // Sosial Media
            'kampus_instagram' => 'nullable|string|max:255',
            'kampus_facebook' => 'nullable|string|max:255',
            'kampus_linkedin' => 'nullable|string|max:255',
            'kampus_xtwitter' => 'nullable|string|max:255',
            'kampus_tiktok' => 'nullable|string|max:255',
            
            // Keamanan
            'maintenance_mode' => 'nullable|boolean',
            'enable_captcha' => 'nullable|boolean',
            'max_login_attempts' => 'nullable|integer|min:1|max:10',
            'login_decay_seconds' => 'nullable|integer|min:30|max:3600',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'app_name' => 'Nama Aplikasi',
            'app_version' => 'Versi Aplikasi',
            'app_description' => 'Deskripsi Aplikasi',
            'app_url' => 'URL Aplikasi',
            'app_email' => 'Email Aplikasi',
            'kampus_name' => 'Nama Kampus',
            'kampus_domain' => 'Domain Kampus',
            'kampus_phone' => 'Nomor Telepon',
            'kampus_faximile' => 'Faximile',
            'kampus_whatsapp' => 'WhatsApp',
            'kampus_email_info' => 'Email Info',
            'kampus_email_humas' => 'Email Humas',
            'app_favicon' => 'Favicon',
            'app_logo_vertikal' => 'Logo Vertikal',
            'app_logo_horizontal' => 'Logo Horizontal',
            'kampus_alamat' => 'Alamat Kampus',
            'kampus_rt' => 'RT',
            'kampus_rw' => 'RW',
            'kampus_kelurahan' => 'Kelurahan/Desa',
            'kampus_kecamatan' => 'Kecamatan',
            'kampus_kota_kabupaten' => 'Kota/Kabupaten',
            'kampus_provinsi' => 'Provinsi',
            'kampus_kode_pos' => 'Kode Pos',
            'kampus_langtitude' => 'Latitude',
            'kampus_longitude' => 'Longitude',
            'kampus_instagram' => 'Instagram',
            'kampus_facebook' => 'Facebook',
            'kampus_linkedin' => 'LinkedIn',
            'kampus_xtwitter' => 'X/Twitter',
            'kampus_tiktok' => 'TikTok',
            'maintenance_mode' => 'Mode Maintenance',
            'enable_captcha' => 'Aktifkan CAPTCHA',
            'max_login_attempts' => 'Batas Percobaan Login',
            'login_decay_seconds' => 'Waktu Reset Percobaan Login',
        ];
    }
}