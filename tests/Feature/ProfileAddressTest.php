<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Referensi\Alamat;
use App\Services\Private\UpdateProfileService;

class ProfileAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function service_enforces_single_ktp_address()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'code' => 'USR001',
            'password' => bcrypt('password'),
        ]);
        
        $service = new UpdateProfileService();
        
        // Mock the Auth facade to return our user
        $this->actingAs($user);
        
        // Create first KTP address through service
        $service->updateProfile([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'alamat_ktp' => [
                'alamat_lengkap' => 'Jl. Test No. 1',
                'kelurahan' => 'Test Kelurahan',
                'kecamatan' => 'Test Kecamatan',
                'kota_kabupaten' => 'Test City',
                'provinsi' => 'Test Province',
                'kode_pos' => '12345',
                'rt' => '001',
                'rw' => '002',
            ]
        ]);
        
        // Create second KTP address through service
        $service->updateProfile([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'alamat_ktp' => [
                'alamat_lengkap' => 'Jl. Test No. 2',
                'kelurahan' => 'Test Kelurahan 2',
                'kecamatan' => 'Test Kecamatan 2',
                'kota_kabupaten' => 'Test City 2',
                'provinsi' => 'Test Province 2',
                'kode_pos' => '12346',
                'rt' => '003',
                'rw' => '004',
            ]
        ]);
        
        // Refresh user
        $user->refresh();
        
        // Check that user still only has one KTP address
        $this->assertEquals(1, $user->alamatKtp()->count());
        $this->assertEquals('Jl. Test No. 2', $user->alamatKtp()->first()->alamat_lengkap);
    }
    
    /** @test */
    public function service_enforces_single_domisili_address()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'phone' => '081234567891',
            'code' => 'USR002',
            'password' => bcrypt('password'),
        ]);
        
        $service = new UpdateProfileService();
        
        // Mock the Auth facade to return our user
        $this->actingAs($user);
        
        // Create first domisili address through service
        $service->updateProfile([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'phone' => '081234567891',
            'alamat_domisili' => [
                'alamat_lengkap' => 'Jl. Domisili No. 1',
                'kelurahan' => 'Domisili Kelurahan',
                'kecamatan' => 'Domisili Kecamatan',
                'kota_kabupaten' => 'Domisili City',
                'provinsi' => 'Domisili Province',
                'kode_pos' => '12347',
                'rt' => '005',
                'rw' => '006',
            ]
        ]);
        
        // Create second domisili address through service
        $service->updateProfile([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'phone' => '081234567891',
            'alamat_domisili' => [
                'alamat_lengkap' => 'Jl. Domisili No. 2',
                'kelurahan' => 'Domisili Kelurahan 2',
                'kecamatan' => 'Domisili Kecamatan 2',
                'kota_kabupaten' => 'Domisili City 2',
                'provinsi' => 'Domisili Province 2',
                'kode_pos' => '12348',
                'rt' => '007',
                'rw' => '008',
            ]
        ]);
        
        // Refresh user
        $user->refresh();
        
        // Check that user still only has one domisili address
        $this->assertEquals(1, $user->alamatDomisili()->count());
        $this->assertEquals('Jl. Domisili No. 2', $user->alamatDomisili()->first()->alamat_lengkap);
    }
    
    /** @test */
    public function user_can_have_multiple_education_records()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User 3',
            'email' => 'test3@example.com',
            'phone' => '081234567892',
            'code' => 'USR003',
            'password' => bcrypt('password'),
        ]);
        
        // Create multiple education records
        $education1 = new \App\Models\Referensi\Pendidikan([
            'jenjang' => 'S1',
            'nama_institusi' => 'University 1',
            'jurusan' => 'Computer Science',
            'tahun_masuk' => 2010,
            'tahun_lulus' => 2014,
            'owner_type' => get_class($user),
            'owner_id' => $user->id,
        ]);
        $user->pendidikans()->save($education1);
        
        $education2 = new \App\Models\Referensi\Pendidikan([
            'jenjang' => 'S2',
            'nama_institusi' => 'University 2',
            'jurusan' => 'Information Technology',
            'tahun_masuk' => 2015,
            'tahun_lulus' => 2017,
            'owner_type' => get_class($user),
            'owner_id' => $user->id,
        ]);
        $user->pendidikans()->save($education2);
        
        // Refresh user
        $user->refresh();
        
        // Check that user has both education records
        $this->assertEquals(2, $user->pendidikans()->count());
    }
    
    /** @test */
    public function user_can_have_multiple_family_records()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User 4',
            'email' => 'test4@example.com',
            'phone' => '081234567893',
            'code' => 'USR004',
            'password' => bcrypt('password'),
        ]);
        
        // Create multiple family records
        $family1 = new \App\Models\Referensi\Keluarga([
            'hubungan' => 'Ayah',
            'nama' => 'Father Name',
            'pekerjaan' => 'Engineer',
            'owner_type' => get_class($user),
            'owner_id' => $user->id,
        ]);
        $user->keluargas()->save($family1);
        
        $family2 = new \App\Models\Referensi\Keluarga([
            'hubungan' => 'Ibu',
            'nama' => 'Mother Name',
            'pekerjaan' => 'Teacher',
            'owner_type' => get_class($user),
            'owner_id' => $user->id,
        ]);
        $user->keluargas()->save($family2);
        
        // Refresh user
        $user->refresh();
        
        // Check that user has both family records
        $this->assertEquals(2, $user->keluargas()->count());
    }
}