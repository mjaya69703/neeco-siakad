<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            \Database\Seeders\PengaturanSeeder::class,
            \Database\Seeders\ReferensiSeeder::class,
            \Database\Seeders\UserSeeder::class,
        ]);
    }
}
