<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Seeder Referensi
        $dataAgama = 
        [
            ['id' => 1, 'name' => 'Islam'],
            ['id' => 2, 'name' => 'Kristen'],
            ['id' => 3, 'name' => 'Katolik'],
            ['id' => 4, 'name' => 'Hindu'],
            ['id' => 5, 'name' => 'Budha'],
            ['id' => 6, 'name' => 'Konghucu'],

        ];

        foreach($dataAgama as $agama){
            \App\Models\Referensi\Agama::create($agama);
        }

        $dataGolonganDarah = 
        [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'AB'],
            ['id' => 4, 'name' => 'O'],

        ];

        foreach($dataGolonganDarah as $golonganDarah){
            \App\Models\Referensi\GolonganDarah::create($golonganDarah);
        }

        $dataJenisKelamin = 
        [
            ['id' => 1, 'name' => 'Laki-Laki'],
            ['id' => 2, 'name' => 'Perempuan'],

        ];

        foreach($dataJenisKelamin as $jenisKelamin){
            \App\Models\Referensi\JenisKelamin::create($jenisKelamin);
        }

        $dataKewarganegaraan = 
        [
            ['id' => 1, 'name' => 'Indonesia'],
            ['id' => 2, 'name' => 'Malaysia'],
            ['id' => 3, 'name' => 'Singapura'],
            ['id' => 4, 'name' => 'Brunei Darussalam'],
            ['id' => 5, 'name' => 'Lainnya'],

        ];

        foreach($dataKewarganegaraan as $kewarganegaraan){
            \App\Models\Referensi\Kewarganegaraan::create($kewarganegaraan);
        }

        // Roles Relations
        $dataJabatans = [
            ['name' => 'Rektor', 'Divisi' => 'Pimpinan'],
            ['name' => 'Wakil Rektor', 'Divisi' => 'Pimpinan'],
        ];

        // Roles Semester
        $dataSemesters = [
            ['name' => 'Semester 1'],
            ['name' => 'Semester 2'],
            ['name' => 'Semester 3'],
            ['name' => 'Semester 4'],
            ['name' => 'Semester 5'],
            ['name' => 'Semester 6'],
            ['name' => 'Semester 7'],
            ['name' => 'Semester 8'],
            ['name' => 'Semester 9'],
            ['name' => 'Semester 10'],
            ['name' => 'Semester 11'],
            ['name' => 'Semester 12'],
            ['name' => 'Semester 13'],
            ['name' => 'Semester 14'],
        ];

        foreach ($dataSemesters as $semester)
        {
            \App\Models\Referensi\Semester::create($semester);
        }

    }
}
