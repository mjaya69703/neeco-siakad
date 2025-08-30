<?php

namespace App\Services;

use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdatePengaturanService
{
    /**
     * Update system and academy settings.
     *
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        try {
            DB::beginTransaction();

            // Update System Settings
            $system = System::first();
            if ($system) {
                $system->app_name = $data['app_name'];
                $system->app_version = $data['app_version'] ?? $system->app_version;
                $system->app_description = $data['app_description'] ?? $system->app_description;
                $system->app_url = $data['app_url'] ?? $system->app_url;
                $system->app_email = $data['app_email'] ?? $system->app_email;
                $system->maintenance_mode = isset($data['maintenance_mode']) && $data['maintenance_mode'] == '1';
                $system->enable_captcha = isset($data['enable_captcha']) && $data['enable_captcha'] == '1';
                $system->max_login_attempts = $data['max_login_attempts'] ?? $system->max_login_attempts;
                $system->login_decay_seconds = $data['login_decay_seconds'] ?? $system->login_decay_seconds;

                // Handle image uploads
                if (isset($data['app_favicon'])) {
                    $this->deleteOldImage('logo', $system->app_favicon);
                    $system->app_favicon = $this->uploadImage($data['app_favicon'], 'logo');
                }

                if (isset($data['app_logo_vertikal'])) {
                    $this->deleteOldImage('logo', $system->app_logo_vertikal);
                    $system->app_logo_vertikal = $this->uploadImage($data['app_logo_vertikal'], 'logo');
                }

                if (isset($data['app_logo_horizontal'])) {
                    $this->deleteOldImage('logo', $system->app_logo_horizontal);
                    $system->app_logo_horizontal = $this->uploadImage($data['app_logo_horizontal'], 'logo');
                }

                $system->save();
            }

            // Update Academy Settings
            $academy = Kampus::first();
            if ($academy) {
                $academy->name = $data['kampus_name'];
                $academy->domain = $data['kampus_domain'] ?? $academy->domain;
                $academy->phone = $data['kampus_phone'] ?? $academy->phone;
                $academy->faximile = $data['kampus_faximile'] ?? $academy->faximile;
                $academy->whatsapp = $data['kampus_whatsapp'] ?? $academy->whatsapp;
                $academy->email_info = $data['kampus_email_info'] ?? $academy->email_info;
                $academy->email_humas = $data['kampus_email_humas'] ?? $academy->email_humas;
                
                // Address information
                $academy->alamat = $data['kampus_alamat'] ?? $academy->alamat;
                $academy->rt = $data['kampus_rt'] ?? $academy->rt;
                $academy->rw = $data['kampus_rw'] ?? $academy->rw;
                $academy->kelurahan = $data['kampus_kelurahan'] ?? $academy->kelurahan;
                $academy->kecamatan = $data['kampus_kecamatan'] ?? $academy->kecamatan;
                $academy->kota_kabupaten = $data['kampus_kota_kabupaten'] ?? $academy->kota_kabupaten;
                $academy->provinsi = $data['kampus_provinsi'] ?? $academy->provinsi;
                $academy->kode_pos = $data['kampus_kode_pos'] ?? $academy->kode_pos;
                $academy->langtitude = $data['kampus_langtitude'] ?? $academy->langtitude;
                $academy->longitude = $data['kampus_longitude'] ?? $academy->longitude;
                
                // Social media
                $academy->instagram = $data['kampus_instagram'] ?? $academy->instagram;
                $academy->facebook = $data['kampus_facebook'] ?? $academy->facebook;
                $academy->linkedin = $data['kampus_linkedin'] ?? $academy->linkedin;
                $academy->xtwitter = $data['kampus_xtwitter'] ?? $academy->xtwitter;
                $academy->tiktok = $data['kampus_tiktok'] ?? $academy->tiktok;
                
                $academy->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Upload an image to storage.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folder
     * @return string
     */
    private function uploadImage($image, $folder)
    {
        $filename = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/images/' . $folder, $filename);
        return $filename;
    }

    /**
     * Delete old image from storage.
     *
     * @param string $folder
     * @param string|null $filename
     * @return void
     */
    private function deleteOldImage($folder, $filename)
    {
        if ($filename && Storage::exists('public/images/' . $folder . '/' . $filename)) {
            Storage::delete('public/images/' . $folder . '/' . $filename);
        }
    }
}