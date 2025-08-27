<?php

namespace App\Services\Private;
// Use System
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// Use Plugin
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateProfileService
{
    public function updateProfile(array $data){

        $user = Auth::user() ?: Auth::guard('mahasiswa')->user();

        try {

            DB::beginTransaction();
            $this->updateBasicInfo($user, $data);
            $this->updatePhoto($user, $data);
            $this->updatePassword($user, $data);
            $this->syncEducation($user, $data);
            $this->syncKeluarga($user, $data);
            $this->syncAlamat($user, $data);

            DB::commit();
            
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Service error occurred', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ]);
        }
    }

    private function updateBasicInfo($user,array $in){
        $data = [
            'name'               => $in['name'] ?? $user->name,
            'username'           => $in['username'] ?? $user->username,
            'email'              => $in['email'] ?? $user->email,
            'phone'              => $in['phone'] ?? $user->phone,
            
            'agama_id'           => $in['agama_id'] ?? $user->agama_id,
            'golongan_darah_id'  => $in['golongan_darah_id'] ?? $user->golongan_darah_id,
            'jenis_kelamin_id'   => $in['jenis_kelamin_id'] ?? $user->jenis_kelamin_id,
            'kewarganegaraan_id' => $in['kewarganegaraan_id'] ?? $user->kewarganegaraan_id,
            
            'tinggi_badan'       => $in['tinggi_badan'] ?? $user->tinggi_badan,
            'berat_badan'        => $in['berat_badan'] ?? $user->berat_badan,
            'tempat_lahir'       => $in['tempat_lahir'] ?? $user->tempat_lahir,
            'tanggal_lahir'      => $in['tanggal_lahir'] ?? $user->tanggal_lahir,
            
            'link_ig'            => $in['link_ig'] ?? $user->link_ig,
            'link_fb'            => $in['link_fb'] ?? $user->link_fb,
            'link_in'            => $in['link_in'] ?? $user->link_in,

            'nomor_kk'           => $in['nomor_kk'] ?? $user->nomor_kk,
            'nomor_ktp'          => $in['nomor_ktp'] ?? $user->nomor_ktp,
            'nomor_npwp'         => $in['nomor_npwp'] ?? $user->nomor_npwp,

            'fst_setup'          => !empty($in['fst_setup']) ? 1 : 0,
            'tfa_setup'          => !empty($in['tfa_setup']) ? 1 : 0,
            'updated_by'         => $user->id,
        ];

        $filtered = array_filter($data, fn($v) => $v !== null);

        $user->update($filtered);
    }

    private function updatePhoto($user, array $in)
    {

        if (!isset($in['photo']) || !$in['photo']->isValid()) {
            return ;
        }

        $file = $in['photo'];

        if ($user->photo && $user->photo !== 'default.jpg') {
            Storage::delete('images/profile/'.$user->photo);
        }

        $fileName = $user->code .'-'. uniqid().'-'.time().'.jpg';

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        if ($image->height() > 1200){
            $image->scaleDown(height: 1200);
        }
        
        Storage::disk('public')->put('images/profile/' . $fileName, $image->toJpeg(90));

        $user->update(['photo' => $fileName]);
    }

    private function updatePassword($user, array $in)
    {
        // Kalau field password kosong, skip
        if (empty($in['current_password']) || empty($in['new_password'])) {
            return;
        }

        // Cek current password
        if (!Hash::check($in['current_password'], $user->password)) {
            throw new \Exception('Password saat ini tidak valid');
        }

        // Update password
        $user->update([
            'password'   => Hash::make($in['new_password']),
            'updated_by' => $user->id,
        ]);
    }


    private function syncEducation($user, array $in)
    {
        if (!isset($in['pendidikan']) || !is_array($in['pendidikan'])) {
            return;
        }

        foreach ($in['pendidikan'] as $pendidikanData) {
            // Skip if required fields are empty
            if (empty($pendidikanData['jenjang']) || empty($pendidikanData['nama_institusi'])) {
                continue;
            }

            $pendidikanData = array_filter($pendidikanData, fn($v) => $v !== null && $v !== '');
            $pendidikanData['owner_id'] = $user->id;
            $pendidikanData['owner_type'] = get_class($user);
            $pendidikanData['updated_by'] = $user->id;

            if (!empty($pendidikanData['id'])) {
                // Update existing record
                $existingPendidikan = $user->pendidikans()->find($pendidikanData['id']);
                if ($existingPendidikan) {
                    unset($pendidikanData['id']);
                    $existingPendidikan->update($pendidikanData);
                }
            } else {
                // Create new record
                unset($pendidikanData['id']);
                $pendidikanData['created_by'] = $user->id;
                $user->pendidikans()->create($pendidikanData);
            }
        }
    }

    private function syncKeluarga($user, array $in)
    {
        if (!isset($in['keluarga']) || !is_array($in['keluarga'])) {
            return;
        }

        foreach ($in['keluarga'] as $keluargaData) {
            // Skip if required fields are empty
            if (empty($keluargaData['hubungan']) || empty($keluargaData['nama'])) {
                continue;
            }

            $keluargaData = array_filter($keluargaData, fn($v) => $v !== null && $v !== '');
            $keluargaData['owner_id'] = $user->id;
            $keluargaData['owner_type'] = get_class($user);
            $keluargaData['updated_by'] = $user->id;

            if (!empty($keluargaData['id'])) {
                // Update existing record
                $existingKeluarga = $user->keluargas()->find($keluargaData['id']);
                if ($existingKeluarga) {
                    unset($keluargaData['id']);
                    $existingKeluarga->update($keluargaData);
                }
            } else {
                // Create new record
                unset($keluargaData['id']);
                $keluargaData['created_by'] = $user->id;
                $user->keluargas()->create($keluargaData);
            }
        }
    }

    private function syncAlamat($user, array $in)
    {
        // Sync Alamat KTP
        if (isset($in['alamat_ktp']) && is_array($in['alamat_ktp'])) {
            $alamatKtpData = $in['alamat_ktp'];
            
            // Only process if alamat_lengkap is provided
            if (!empty($alamatKtpData['alamat_lengkap'])) {
                

                
                $alamatKtpData = array_filter($alamatKtpData, fn($v) => $v !== null && $v !== '');
                $alamatKtpData['owner_id'] = $user->id;
                $alamatKtpData['owner_type'] = get_class($user);
                $alamatKtpData['tipe'] = 'ktp';
                $alamatKtpData['updated_by'] = $user->id;

                if (!empty($alamatKtpData['id'])) {
                    // Update existing KTP address
                    $existingAlamatKtp = $user->alamats()->where('tipe', 'ktp')->find($alamatKtpData['id']);
                    if ($existingAlamatKtp) {
                        unset($alamatKtpData['id']);
                        $existingAlamatKtp->update($alamatKtpData);
                    }
                } else {
                    // Create new KTP address
                    unset($alamatKtpData['id']);
                    $alamatKtpData['created_by'] = $user->id;
                    $user->alamats()->create($alamatKtpData);
                }
            }
        }

        // Sync Alamat Domisili
        if (isset($in['alamat_domisili']) && is_array($in['alamat_domisili'])) {
            $alamatDomisiliData = $in['alamat_domisili'];
            
            // Only process if alamat_lengkap is provided
            if (!empty($alamatDomisiliData['alamat_lengkap'])) {
                
                $alamatDomisiliData = array_filter($alamatDomisiliData, fn($v) => $v !== null && $v !== '');
                $alamatDomisiliData['owner_id'] = $user->id;
                $alamatDomisiliData['owner_type'] = get_class($user);
                $alamatDomisiliData['tipe'] = 'domisili';
                $alamatDomisiliData['updated_by'] = $user->id;

                if (!empty($alamatDomisiliData['id'])) {
                    // Update existing domisili address
                    $existingAlamatDomisili = $user->alamats()->where('tipe', 'domisili')->find($alamatDomisiliData['id']);
                    if ($existingAlamatDomisili) {
                        unset($alamatDomisiliData['id']);
                        $existingAlamatDomisili->update($alamatDomisiliData);
                    }
                } else {
                    // Create new domisili address
                    unset($alamatDomisiliData['id']);
                    $alamatDomisiliData['created_by'] = $user->id;
                    $user->alamats()->create($alamatDomisiliData);
                }
            }
        }
    }
}