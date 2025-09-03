<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for tahun_akademik table
        DB::table('tahun_akademik')->insert([
            [
                'name' => 'Tahun Akademik 2023/2024',
                'code' => 'TA20232024',
                'semester' => 'Ganjil',
                'tanggal_mulai' => '2023-09-01',
                'tanggal_selesai' => '2024-01-31',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Tahun Akademik 2023/2024',
                'code' => 'TA20232024G',
                'semester' => 'Genap',
                'tanggal_mulai' => '2024-02-01',
                'tanggal_selesai' => '2024-07-31',
                'is_active' => false,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        
        // Sample data for fakultas table
        DB::table('fakultas')->insert([
            [
                'name' => 'Fakultas Teknik',
                'code' => 'FT',
                'nama_singkat' => 'FT',
                'akreditasi' => 'A',
                'tanggal_akreditasi' => '2023-01-01',
                'sk_pendirian' => 'SK-FT-001',
                'tanggal_sk_pendirian' => '2020-01-01',
                'dekan_id' => null,
                'sekretaris_id' => null,
                'email' => 'ft@universitas.ac.id',
                'telepon' => '021-123456',
                'alamat' => 'Gedung FT Lt. 1',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Fakultas Ekonomi dan Bisnis',
                'code' => 'FEB',
                'nama_singkat' => 'FEB',
                'akreditasi' => 'A',
                'tanggal_akreditasi' => '2023-01-01',
                'sk_pendirian' => 'SK-FEB-001',
                'tanggal_sk_pendirian' => '2020-01-01',
                'dekan_id' => null,
                'sekretaris_id' => null,
                'email' => 'feb@universitas.ac.id',
                'telepon' => '021-654321',
                'alamat' => 'Gedung FEB Lt. 1',
                'is_active' => true,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}