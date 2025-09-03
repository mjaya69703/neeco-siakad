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
// Use Models
use App\Models\Referensi\Alamat;

class UpdateProfileService
{
    public function updateProfile(array $data){

        $user = Auth::user() ?: Auth::guard('mahasiswa')->user();

        try {

            DB::beginTransaction();
            
            // Only run updates when relevant data is present
            if ($this->hasBasicInfoData($data)) {
                $this->updateBasicInfo($user, $data);
            }
            
            if (isset($data['photo']) && $data['photo']->isValid()) {
                $this->updatePhoto($user, $data);
            }
            
            if ($this->hasAddressData($data)) {
                $this->updateAddresses($user, $data);
            }
            
            if ($this->hasEducationData($data)) {
                $this->updateEducations($user, $data);
            }
            
            if ($this->hasFamilyData($data)) {
                $this->updateFamilies($user, $data);
            }
            
            if (!empty($data['current_password']) && !empty($data['new_password'])) {
                $this->updatePassword($user, $data);
            }

            DB::commit();
            
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Service error occurred', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ]);
            throw $th;
        }
    }

    private function hasBasicInfoData(array $data): bool
    {
        $basicInfoFields = [
            'name', 'username', 'email', 'phone', 'agama_id', 'golongan_darah_id',
            'jenis_kelamin_id', 'kewarganegaraan_id', 'tinggi_badan', 'berat_badan',
            'tempat_lahir', 'tanggal_lahir', 'link_ig', 'link_fb', 'link_in',
            'nomor_kk', 'nomor_ktp', 'nomor_npwp', 'fst_setup', 'tfa_setup'
        ];
        
        foreach ($basicInfoFields as $field) {
            if (isset($data[$field])) {
                return true;
            }
        }
        
        return false;
    }

    private function hasAddressData(array $data): bool
    {
        return isset($data['alamat_ktp']) || isset($data['alamat_domisili']);
    }

    private function hasEducationData(array $data): bool
    {
        return isset($data['pendidikan']) || isset($data['deleted_pendidikan']);
    }

    private function hasFamilyData(array $data): bool
    {
        return isset($data['keluarga']) || isset($data['deleted_keluarga']);
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

    private function updateAddresses($user, array $in)
    {
        // Update or create KTP address
        if (isset($in['alamat_ktp'])) {
            $ktpData = $in['alamat_ktp'];
            
            // Remove empty values
            $ktpData = array_filter($ktpData, function($value) {
                return $value !== null && $value !== '';
            });
            
            // Only proceed if we have data to save
            if (!empty($ktpData)) {
                // Check if user already has a KTP address
                $existingKtp = $user->alamatKtp()->first();
                
                // Make sure we have the required fields for owner relationship
                $ktpData['owner_type'] = get_class($user);
                $ktpData['owner_id'] = $user->id;
                $ktpData['tipe'] = 'ktp';
                
                if ($existingKtp) {
                    // Update existing KTP address
                    $existingKtp->update($ktpData);
                } else {
                    // Create new KTP address using the relationship
                    $ktpData['created_by'] = $user->id;
                    $user->alamats()->create($ktpData);
                }
            }
        }

        // Update or create Domisili address
        if (isset($in['alamat_domisili'])) {
            $domisiliData = $in['alamat_domisili'];
            
            // Remove empty values
            $domisiliData = array_filter($domisiliData, function($value) {
                return $value !== null && $value !== '';
            });
            
            // Only proceed if we have data to save
            if (!empty($domisiliData)) {
                // Check if user already has a Domisili address
                $existingDomisili = $user->alamatDomisili()->first();
                
                // Make sure we have the required fields for owner relationship
                $domisiliData['owner_type'] = get_class($user);
                $domisiliData['owner_id'] = $user->id;
                $domisiliData['tipe'] = 'domisili';
                
                if ($existingDomisili) {
                    // Update existing Domisili address
                    $existingDomisili->update($domisiliData);
                } else {
                    // Create new Domisili address using the relationship
                    $domisiliData['created_by'] = $user->id;
                    $user->alamats()->create($domisiliData);
                }
            }
        }
    }

    private function updateEducations($user, array $in)
    {
        // Handle education records (allow multiple)
        if (isset($in['pendidikan']) && is_array($in['pendidikan'])) {
            $existingIds = [];
            
            foreach ($in['pendidikan'] as $pendidikanData) {
                // Remove empty values
                $pendidikanData = array_filter($pendidikanData, function($value) {
                    return $value !== null && $value !== '';
                });
                
                // Skip if no data
                if (empty($pendidikanData)) {
                    continue;
                }
                
                // Make sure we have the required fields for owner relationship
                $pendidikanData['owner_type'] = get_class($user);
                $pendidikanData['owner_id'] = $user->id;
                
                if (!empty($pendidikanData['id'])) {
                    // Update existing education record
                    $pendidikan = $user->pendidikans()->find($pendidikanData['id']);
                    if ($pendidikan) {
                        $pendidikan->update($pendidikanData);
                        $existingIds[] = $pendidikanData['id'];
                    }
                } else {
                    // Create new education record
                    $pendidikanData['created_by'] = $user->id;
                    $newPendidikan = $user->pendidikans()->create($pendidikanData);
                    $existingIds[] = $newPendidikan->id;
                }
            }
            
            // Delete education records that are no longer in the input
            $user->pendidikans()->whereNotIn('id', $existingIds)->delete();
        } else {
            // If no education data is provided, delete all existing records
            $user->pendidikans()->delete();
        }
        
        // Handle deleted education records (from the hidden input field)
        if (!empty($in['deleted_pendidikan'])) {
            $deletedIds = explode(',', $in['deleted_pendidikan']);
            foreach ($deletedIds as $id) {
                $pendidikan = $user->pendidikans()->find($id);
                if ($pendidikan) {
                    $pendidikan->delete();
                }
            }
        }
    }

    private function updateFamilies($user, array $in)
    {
        // Handle family records (allow multiple)
        if (isset($in['keluarga']) && is_array($in['keluarga'])) {
            $existingIds = [];
            
            foreach ($in['keluarga'] as $keluargaData) {
                // Remove empty values
                $keluargaData = array_filter($keluargaData, function($value) {
                    return $value !== null && $value !== '';
                });
                
                // Skip if no data
                if (empty($keluargaData)) {
                    continue;
                }
                
                // Make sure we have the required fields for owner relationship
                $keluargaData['owner_type'] = get_class($user);
                $keluargaData['owner_id'] = $user->id;
                
                if (!empty($keluargaData['id'])) {
                    // Update existing family record
                    $keluarga = $user->keluargas()->find($keluargaData['id']);
                    if ($keluarga) {
                        $keluarga->update($keluargaData);
                        $existingIds[] = $keluargaData['id'];
                    }
                } else {
                    // Create new family record
                    $keluargaData['created_by'] = $user->id;
                    $newKeluarga = $user->keluargas()->create($keluargaData);
                    $existingIds[] = $newKeluarga->id;
                }
            }
            
            // Delete family records that are no longer in the input
            $user->keluargas()->whereNotIn('id', $existingIds)->delete();
        } else {
            // If no family data is provided, delete all existing records
            $user->keluargas()->delete();
        }
        
        // Handle deleted family records (from the hidden input field)
        if (!empty($in['deleted_keluarga'])) {
            $deletedIds = explode(',', $in['deleted_keluarga']);
            foreach ($deletedIds as $id) {
                $keluarga = $user->keluargas()->find($id);
                if ($keluarga) {
                    $keluarga->delete();
                }
            }
        }
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

}