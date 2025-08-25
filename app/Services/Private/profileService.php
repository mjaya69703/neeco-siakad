<?php

namespace App\Services\Private;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Referensi\Alamat;
use App\Models\Referensi\Pendidikan;
use App\Models\Referensi\Keluarga;
use Exception;

class profileService
{
    /**
     * Update user profile with all related data
     */
    public function updateProfile(User $user, array $data): array
    {
        try {
            DB::beginTransaction();

            // Update basic user information
            $this->updateBasicInfo($user, $data);

            // Handle photo upload
            if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
                $this->updatePhoto($user, $data['photo']);
            }

            // Update addresses
            $this->updateAddresses($user, $data);

            // Update education records
            if (isset($data['pendidikan'])) {
                $this->updateEducation($user, $data['pendidikan']);
            }

            // Update family records
            if (isset($data['keluarga'])) {
                $this->updateFamily($user, $data['keluarga']);
            }

            // Update password if provided
            if (!empty($data['new_password'])) {
                $this->updatePassword($user, $data['new_password']);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
                'user' => $user->fresh()
            ];
        } catch (Exception $e) {
            DB::rollBack();
            
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update basic user information
     */
    private function updateBasicInfo(User $user, array $data): void
    {
        $basicFields = [
            'name', 'username', 'email', 'phone',
            'jenis_kelamin_id', 'tempat_lahir', 'tanggal_lahir',
            'agama_id', 'golongan_darah_id', 'kewarganegaraan_id',
            'tinggi_badan', 'berat_badan',
            'link_ig', 'link_fb', 'link_in',
            'nomor_kk', 'nomor_ktp', 'nomor_npwp',
            'fst_setup', 'tfa_setup'
        ];

        $updateData = [];
        foreach ($basicFields as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = $data[$field];
            }
        }

        // Convert boolean fields
        if (isset($updateData['fst_setup'])) {
            $updateData['fst_setup'] = (bool) $updateData['fst_setup'];
        }
        if (isset($updateData['tfa_setup'])) {
            $updateData['tfa_setup'] = (bool) $updateData['tfa_setup'];
        }

        $user->update($updateData);
    }

    /**
     * Handle photo upload and update
     */
    private function updatePhoto(User $user, UploadedFile $photo): void
    {
        // Delete old photo if not default
        if ($user->getRawOriginal('photo') !== 'default.jpg') {
            Storage::delete('images/profile/' . $user->getRawOriginal('photo'));
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
        
        // Store new photo
        $photo->storeAs('images/profile', $filename);
        
        // Update user record
        $user->update(['photo' => $filename]);
    }

    /**
     * Update user addresses (KTP and Domisili)
     */
    private function updateAddresses(User $user, array $data): void
    {
        // Update KTP address
        if (isset($data['alamat_ktp'])) {
            $this->updateSingleAddress($user, $data['alamat_ktp'], 'ktp');
        }

        // Update Domisili address
        if (isset($data['alamat_domisili'])) {
            $this->updateSingleAddress($user, $data['alamat_domisili'], 'domisili');
        }
    }

    /**
     * Update single address record
     */
    private function updateSingleAddress(User $user, array $addressData, string $type): void
    {
        // Skip if no meaningful data
        $hasData = false;
        foreach ($addressData as $key => $value) {
            if ($key !== 'id' && $key !== 'tipe' && !empty($value)) {
                $hasData = true;
                break;
            }
        }

        if (!$hasData) {
            return;
        }

        $addressData['tipe'] = $type;
        
        if (!empty($addressData['id'])) {
            // Update existing address
            $alamat = Alamat::find($addressData['id']);
            if ($alamat && $alamat->owner_id === $user->id) {
                $alamat->update($addressData);
            }
        } else {
            // Create new address
            $user->alamats()->create($addressData);
        }
    }

    /**
     * Update education records
     */
    private function updateEducation(User $user, array $educationData): void
    {
        foreach ($educationData as $eduData) {
            // Skip empty records
            if (empty($eduData['jenjang']) || empty($eduData['nama_institusi'])) {
                continue;
            }

            if (!empty($eduData['id'])) {
                // Update existing education
                $pendidikan = Pendidikan::find($eduData['id']);
                if ($pendidikan && $pendidikan->owner_id === $user->id) {
                    $pendidikan->update($eduData);
                }
            } else {
                // Create new education
                $user->pendidikans()->create($eduData);
            }
        }
    }

    /**
     * Update family records
     */
    private function updateFamily(User $user, array $familyData): void
    {
        foreach ($familyData as $famData) {
            // Skip empty records
            if (empty($famData['hubungan']) || empty($famData['nama'])) {
                continue;
            }

            if (!empty($famData['id'])) {
                // Update existing family
                $keluarga = Keluarga::find($famData['id']);
                if ($keluarga && $keluarga->owner_id === $user->id) {
                    $keluarga->update($famData);
                }
            } else {
                // Create new family
                $user->keluargas()->create($famData);
            }
        }
    }

    /**
     * Update user password
     */
    private function updatePassword(User $user, string $newPassword): void
    {
        $user->update([
            'password' => Hash::make($newPassword)
        ]);
    }

    /**
     * Delete education record
     */
    public function deleteEducation(int $educationId, int $userId): array
    {
        try {
            $pendidikan = Pendidikan::where('id', $educationId)
                ->where('owner_id', $userId)
                ->where('owner_type', User::class)
                ->first();

            if (!$pendidikan) {
                return [
                    'success' => false,
                    'message' => 'Data pendidikan tidak ditemukan.'
                ];
            }

            $pendidikan->delete();

            return [
                'success' => true,
                'message' => 'Data pendidikan berhasil dihapus.'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete family record
     */
    public function deleteFamily(int $familyId, int $userId): array
    {
        try {
            $keluarga = Keluarga::where('id', $familyId)
                ->where('owner_id', $userId)
                ->where('owner_type', User::class)
                ->first();

            if (!$keluarga) {
                return [
                    'success' => false,
                    'message' => 'Data keluarga tidak ditemukan.'
                ];
            }

            $keluarga->delete();

            return [
                'success' => true,
                'message' => 'Data keluarga berhasil dihapus.'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }
}