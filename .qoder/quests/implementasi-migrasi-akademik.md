# Implementation of Academic Modules Based on Migration

## Overview

This document outlines the implementation plan for academic modules based on the migration file `2025_08_27_082329_create_akademiks_modules.php`. The implementation will follow the existing patterns in the system, particularly the Ruangan module implementation.

## Migration Analysis

The migration file contains 16 tables, but we will implement only 10 models as some tables (profile, prerequisite, lecturer, detail) will be accessed via relationships:

1. tahun_akademik
2. fakultas
3. program_studi
4. kurikulum
5. mata_kuliah
6. kurikulum_mata_kuliah
7. kelas_perkuliahan
8. jadwal_perkuliahan
9. jadwal_pertemuan
10. kelas_mahasiswa

## Implementation Structure

### Directory Structure
```
app/
├── Http/
│   └── Controllers/
│       └── Master/
│           └── Akademik/
├── Models/
│   └── Akademik/
database/
├── seeders/
resources/
├── views/
│   └── master/
│       └── akademik/
routes/
```

### Model Implementation Plan

Each model will follow the pattern established in `Ruangan.php` with:
- SoftDeletes trait
- guarded property
- Relationship methods
- Audit field relationships (createdBy, updatedBy, deletedBy)

#### Models to Create:
1. TahunAkademik
2. Fakultas
3. ProgramStudi
4. Kurikulum
5. MataKuliah
6. KurikulumMataKuliah
7. KelasPerkuliahan
8. JadwalPerkuliahan
9. JadwalPertemuan
10. KelasMahasiswa

### Controller Implementation Plan

Each controller will follow the pattern established in `RuanganController.php` with:
- Index method for active records
- Trash method for deleted records
- Store method for creating records
- Update method for modifying records
- Destroy method for soft deleting records
- Restore method for restoring deleted records

#### Controllers to Create:
1. TahunAkademikController
2. FakultasController
3. ProgramStudiController
4. KurikulumController
5. MataKuliahController
6. KurikulumMataKuliahController
7. KelasPerkuliahanController
8. JadwalPerkuliahanController
9. JadwalPertemuanController
10. KelasMahasiswaController

### View Implementation Plan

Each view will follow the pattern established in `ruangan-index.blade.php` with:
- Extends main layout
- Section for custom CSS
- Section for content
- Section for custom JavaScript

#### Views to Create:
1. tahun-akademik-index.blade.php
2. fakultas-index.blade.php
3. program-studi-index.blade.php
4. kurikulum-index.blade.php
5. mata-kuliah-index.blade.php
6. kurikulum-mata-kuliah-index.blade.php
7. kelas-perkuliahan-index.blade.php
8. jadwal-perkuliahan-index.blade.php
9. jadwal-pertemuan-index.blade.php
10. kelas-mahasiswa-index.blade.php

### Route Implementation Plan

Routes will be added to `web.php` following existing patterns with:
- Resource routes for each entity
- Grouped under 'master/akademik' prefix
- Middleware protection for authentication
- Named routes for easy reference
- Proper HTTP verb mapping (GET, POST, PUT, DELETE)

Example route structure:
```
// Akademik Routes
Route::group(['prefix' => 'master/akademik', 'middleware' => ['auth']], function () {
    Route::get('/tahun-akademik', [App\Http\Controllers\Master\Akademik\TahunAkademikController::class, 'index'])->name('akademik.tahun-akademik-index');
    Route::get('/tahun-akademik/trashed', [App\Http\Controllers\Master\Akademik\TahunAkademikController::class, 'trash'])->name('akademik.tahun-akademik-trash');
    Route::post('/tahun-akademik', [App\Http\Controllers\Master\Akademik\TahunAkademikController::class, 'store'])->name('akademik.tahun-akademik-store');
    Route::patch('/tahun-akademik/{id}/update', [App\Http\Controllers\Master\Akademik\TahunAkademikController::class, 'update'])->name('akademik.tahun-akademik-update');
    Route::delete('/tahun-akademik/{id}/delete', [App\Http\Controllers\Master\Akademik\TahunAkademikController::class, 'destroy'])->name('akademik.tahun-akademik-destroy');
    Route::post('/tahun-akademik/{id}/restore', [App\Http\Controllers\Master\Akademik\TahunAkademikController::class, 'restore'])->name('akademik.tahun-akademik-restore');
    
    // Additional routes for other entities
    // Route::resource('fakultas', FakultasController::class);
    // Route::resource('program-studi', ProgramStudiController::class);
    // ... additional routes
});
```

### Navigation Implementation Plan

Navigation will be added to the sidebar with:
- Single "Akademik" dropdown
- Sub-dropdowns as needed for organization
- Following patterns in `sidebar-user.blade.php`

Navigation structure:
```
- Akademik
  - Tahun Akademik
  - Fakultas
  - Program Studi
  - Kurikulum
  - Mata Kuliah
  - Kelas Perkuliahan
  - Jadwal Perkuliahan
```

Implementation details:
- Use existing CSS classes and structure
- Proper icon integration
- Active state management
- Responsive design for mobile

Example navigation code to be added to `resources/views/themes/partials/sidebar-user.blade.php`:

```blade
<li class="sidebar-item {{ request()->is('master/akademik*') ? 'active' : '' }}">
    <a href="#" class="sidebar-link has-dropdown">
        <i class="fas fa-graduation-cap"></i>
        <span>Akademik</span>
    </a>
    <ul class="dropdown-menu">
        <li class="dropdown-item {{ request()->is('master/akademik/tahun-akademik*') ? 'active' : '' }}">
            <a href="{{ route('akademik.tahun-akademik-index') }}" class="dropdown-link">
                <i class="fas fa-calendar-alt"></i>
                <span>Tahun Akademik</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="#" class="dropdown-link">
                <i class="fas fa-building"></i>
                <span>Fakultas</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="#" class="dropdown-link">
                <i class="fas fa-book"></i>
                <span>Program Studi</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="#" class="dropdown-link">
                <i class="fas fa-book-open"></i>
                <span>Kurikulum</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="#" class="dropdown-link">
                <i class="fas fa-book-reader"></i>
                <span>Mata Kuliah</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="#" class="dropdown-link">
                <i class="fas fa-chalkboard"></i>
                <span>Kelas Perkuliahan</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="#" class="dropdown-link">
                <i class="fas fa-clock"></i>
                <span>Jadwal Perkuliahan</span>
            </a>
        </li>
    </ul>
</li>
```

### Seeder Implementation Plan

An `AkademikSeeder` will be created following existing seeder patterns to populate initial data.

### Media Storage Plan

Media files will be stored in:
- `storage/images/logo/fakultas` for faculty logos
- `storage/images/logo/program_studi` for program logos
- Other relevant storage paths as needed

Implementation details:
- Use Laravel's built-in storage functionality
- Store files using symbolic links for public access
- Validate file types and sizes before upload
- Generate unique filenames to prevent conflicts

Example implementation in controller:

```php
// In store method
if ($request->hasFile('logo')) {
    $logoPath = $request->file('logo')->store('images/logo/fakultas', 'public');
    $fakultas->logo = $logoPath;
}

// In update method
if ($request->hasFile('logo')) {
    // Delete old logo if exists
    if ($fakultas->logo) {
        Storage::disk('public')->delete($fakultas->logo);
    }
    
    $logoPath = $request->file('logo')->store('images/logo/fakultas', 'public');
    $fakultas->logo = $logoPath;
}
```

Configuration in `config/filesystems.php`:

```php
'disks' => [
    // ...
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
    // ...
],
```

To create the symbolic link:
```bash
php artisan storage:link
```

### AkademikSeeder Implementation

The AkademikSeeder will follow existing seeder patterns:
- Populate initial data for all 10 models
- Follow foreign key dependencies
- Use factory patterns where applicable
- Include sample data for testing

Example seeder structure:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        
        // Additional seed data for other tables would follow similar pattern
        // ...
    }
}
```

### Model Factories

Factories will be created for each model to facilitate testing and seeding:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Akademik\TahunAkademik;
use Carbon\Carbon;

class TahunAkademikFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TahunAkademik::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap', 'Pendek']),
            'tanggal_mulai' => Carbon::now()->subMonths(6),
            'tanggal_selesai' => Carbon::now()->addMonths(6),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'created_by' => 1,
        ];
    }

    /**
     * Indicate that the tahun akademik is active.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
            ];
        });
    }

    /**
     * Indicate that the tahun akademik is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
```

## Implementation Order

Based on migration dependencies, implementation will proceed in this order:
1. TahunAkademik
2. Fakultas
3. ProgramStudi
4. Kurikulum
5. MataKuliah
6. KurikulumMataKuliah
7. KelasPerkuliahan
8. JadwalPerkuliahan
9. JadwalPertemuan
10. KelasMahasiswa

## Error Handling and Validation

All controllers will implement comprehensive error handling and validation:

1. **Request Validation**: Each controller method will validate incoming requests using Laravel's validation features.
2. **Exception Handling**: Try-catch blocks will be used to handle exceptions gracefully.
3. **User Feedback**: SweetAlert notifications will provide clear feedback to users.
4. **Logging**: Errors will be logged for debugging purposes.

Example validation rules:

```php
$request->validate([
    'name' => 'required|string|max:255',
    'code' => 'required|string|unique:tahun_akademik,code' . ($id ? ',' . $id : ''),
    'semester' => 'required|in:Ganjil,Genap,Pendek',
    'tanggal_mulai' => 'required|date',
    'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    'is_active' => 'required|boolean'
], [
    'name.required' => 'Nama tahun akademik wajib diisi',
    'code.required' => 'Kode tahun akademik wajib diisi',
    'code.unique' => 'Kode tahun akademik sudah ada',
    'semester.required' => 'Semester wajib dipilih',
    'semester.in' => 'Semester tidak valid',
    'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
    'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
    'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
    'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
    'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
    'is_active.required' => 'Status aktif wajib dipilih'
]);
```

## Testing Strategy

Each module will include comprehensive testing:
- Unit tests for models
- Feature tests for controllers
- Browser tests for views
- Factory tests for seeder data

Testing approach:
- Use existing test patterns in the codebase
- Test validation rules
- Test relationship integrity
- Test soft delete functionality
- Test audit field population

### Example Test Structure

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Akademik\TahunAkademik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TahunAkademikTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_view_tahun_akademik_list()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('akademik.tahun-akademik-index'));

        $response->assertStatus(200);
        $response->assertViewHas('tahunAkademiks');
    }

    /** @test */
    public function user_can_create_tahun_akademik()
    {
        $data = [
            'name' => $this->faker->sentence(3),
            'code' => $this->faker->unique()->word(),
            'semester' => 'Ganjil',
            'tanggal_mulai' => '2023-09-01',
            'tanggal_selesai' => '2024-01-31',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('akademik.tahun-akademik-store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('tahun_akademik', $data);
    }

    /** @test */
    public function user_can_update_tahun_akademik()
    {
        $tahunAkademik = TahunAkademik::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'code' => 'UPDATED001',
            'semester' => 'Genap',
            'tanggal_mulai' => '2024-02-01',
            'tanggal_selesai' => '2024-07-31',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)
                         ->patch(route('akademik.tahun-akademik-update', $tahunAkademik->id), $updatedData);

        $response->assertRedirect();
        $this->assertDatabaseHas('tahun_akademik', $updatedData);
    }

    /** @test */
    public function user_can_delete_tahun_akademik()
    {
        $tahunAkademik = TahunAkademik::factory()->create();

        $response = $this->actingAs($this->user)
                         ->delete(route('akademik.tahun-akademik-destroy', $tahunAkademik->id));

        $response->assertRedirect();
        $this->assertSoftDeleted('tahun_akademik', ['id' => $tahunAkademik->id]);
    }

    /** @test */
    public function user_can_restore_tahun_akademik()
    {
        $tahunAkademik = TahunAkademik::factory()->create();
        $tahunAkademik->delete();

        $response = $this->actingAs($this->user)
                         ->post(route('akademik.tahun-akademik-restore', $tahunAkademik->id));

        $response->assertRedirect();
        $this->assertNotSoftDeleted('tahun_akademik', ['id' => $tahunAkademik->id]);
    }
}
```

## Detailed Implementation

### 1. TahunAkademik Module

#### Model: TahunAkademik
- Table: tahun_akademik
- Fields: name, code, semester, tanggal_mulai, tanggal_selesai, is_active
- Relationships: createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Semester enum: Ganjil, Genap, Pendek

#### Controller: TahunAkademikController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback

#### View: tahun-akademik-index.blade.php
- DataTables implementation
- Form for create/update
- Delete/restore functionality
- Custom action buttons as needed
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Date picker for tanggal_mulai and tanggal_selesai fields

### 2. Fakultas Module

#### Model: Fakultas
- Table: fakultas
- Fields: name, code, nama_singkat, akreditasi, tanggal_akreditasi, sk_pendirian, tanggal_sk_pendirian, dekan_id, sekretaris_id, email, telepon, alamat, is_active
- Relationships: dekan, sekretaris, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Foreign key constraints to users table for dekan_id and sekretaris_id
- Profile relationship to FakultasProfile model

#### Controller: FakultasController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- File upload handling for logos and banners

#### View: fakultas-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Custom action buttons for profile management
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Date picker for tanggal_akreditasi and tanggal_sk_pendirian fields
- File upload fields for logos and banners

### 3. ProgramStudi Module

#### Model: ProgramStudi
- Table: program_studi
- Fields: fakultas_id, name, code, nama_singkat, akreditasi, tanggal_akreditasi, sk_pendirian, tanggal_sk_pendirian, jenjang, gelar_depan, gelar_belakang, kaprodi_id, sekretaris_id, is_active
- Relationships: fakultas, kaprodi, sekretaris, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Foreign key constraints to users table for kaprodi_id and sekretaris_id
- Jenjang enum: D3, D4, S1, S2, S3
- Profile relationship to ProgramStudiProfile model

#### Controller: ProgramStudiController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- File upload handling for logos and banners

#### View: program-studi-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Custom action buttons for profile management
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Date picker for tanggal_akreditasi and tanggal_sk_pendirian fields
- File upload fields for logos and banners
- Dropdown for jenjang selection

### 4. Kurikulum Module

#### Model: Kurikulum
- Table: kurikulum
- Fields: program_studi_id, name, code, deskripsi, tahun_berlaku, tahun_berakhir, awal_tahun_akademik_id, akhir_tahun_akademik_id, total_sks_lulus, sks_wajib, sks_pilihan, semester_normal, ipk_minimal, sk_penetapan, tanggal_sk, status
- Relationships: programStudi, awalTahunAkademik, akhirTahunAkademik, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Status enum: Masih Berlaku, Tidak Berlaku
- Relationship to KurikulumMataKuliah for course mappings

#### Controller: KurikulumController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- Year validation for tahun_berlaku and tahun_berakhir

#### View: kurikulum-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Custom action buttons for detail management
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Date picker for tanggal_sk field
- Number inputs for SKS and semester fields
- Dropdown for status selection

### 5. MataKuliah Module

#### Model: MataKuliah
- Table: mata_kuliah
- Fields: semester_id, name, name_en, code, cover, beban_sks, sks_teori, sks_praktik, sks_lapangan, jenis, min_semester, is_active
- Relationships: semester, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Jenis enum: Wajib, Pilihan, MKWU, MKU
- Relationship to MataKuliahPrasyarat for prerequisites
- Relationship to MataKuliahDosen for lecturers
- Relationship to MataKuliahDetail for detailed information

#### Controller: MataKuliahController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- File upload handling for cover images

#### View: mata-kuliah-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Custom action buttons for prerequisite and detail management
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- File upload field for cover image
- Number inputs for SKS fields
- Dropdown for jenis selection

### 6. KurikulumMataKuliah Module

#### Model: KurikulumMataKuliah
- Table: kurikulum_mata_kuliah
- Fields: kurikulum_id, mata_kuliah_id, semester_id, is_wajib, urutan, sks_override, catatan
- Relationships: kurikulum, mataKuliah, semester, createdBy, updatedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Pivot table between Kurikulum and MataKuliah
- Unique constraint on kurikulum_id and mata_kuliah_id

#### Controller: KurikulumMataKuliahController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- Validation for unique constraint on kurikulum_id and mata_kuliah_id

#### View: kurikulum-mata-kuliah-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Select2 or similar for kurikulum, mata_kuliah, and semester selection
- Checkbox for is_wajib field

### 7. KelasPerkuliahan Module

#### Model: KelasPerkuliahan
- Table: kelas_perkuliahan
- Fields: tahun_akademik_id, program_studi_id, mata_kuliah_id, name, code, kapasitas
- Relationships: tahunAkademik, programStudi, mataKuliah, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Relationship to KelasMahasiswa for student enrollment
- Relationship to JadwalPerkuliahan for scheduling

#### Controller: KelasPerkuliahanController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback

#### View: kelas-perkuliahan-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Custom action buttons for student management
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Select2 or similar for tahun_akademik, program_studi, and mata_kuliah selection
- Number input for kapasitas field

### 8. JadwalPerkuliahan Module

#### Model: JadwalPerkuliahan
- Table: jadwal_perkuliahan
- Fields: tahun_akademik_id, mata_kuliah_id, dosen_id, ruang_id, hari, jam_mulai, jam_selesai, metode, status, code
- Relationships: tahunAkademik, mataKuliah, dosen, ruang, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Hari enum: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu
- Metode enum: Tatap Muka, Teleconference, Hybrid
- Status enum: Terjadwal, Terlaksana, Ditunda, Dibatalkan
- Relationship to JadwalKelas for class associations
- Relationship to JadwalPertemuan for meeting details

#### Controller: JadwalPerkuliahanController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- Time validation for jam_mulai and jam_selesai
- Conflict detection for scheduling

#### View: jadwal-perkuliahan-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Custom action buttons for meeting management
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Select2 or similar for tahun_akademik, mata_kuliah, dosen, and ruang selection
- Dropdowns for hari, metode, and status selection
- Time picker for jam_mulai and jam_selesai fields

### 9. JadwalPertemuan Module

#### Model: JadwalPertemuan
- Table: jadwal_pertemuan
- Fields: jadwal_id, pertemuan_ke, tanggal, jam_mulai, jam_selesai, ruang_id, dosen_id, metode, link, materi, is_realisasi
- Relationships: jadwal, ruang, dosen, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Metode enum: Tatap Muka, Teleconference, Hybrid
- Relationship to parent JadwalPerkuliahan
- Override fields for specific meeting changes

#### Controller: JadwalPertemuanController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- Time validation for jam_mulai and jam_selesai
- URL validation for link field

#### View: jadwal-pertemuan-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Select2 or similar for jadwal, ruang, and dosen selection
- Date picker for tanggal field
- Time picker for jam_mulai and jam_selesai fields
- URL input for link field
- Textarea for materi field
- Checkbox for is_realisasi field

### 10. KelasMahasiswa Module

#### Model: KelasMahasiswa
- Table: kelas_mahasiswa
- Fields: kelas_id, mahasiswa_id
- Relationships: kelas, mahasiswa, createdBy, updatedBy, deletedBy
- Implementation based on `Ruangan.php` with SoftDeletes trait
- All fields guarded except audit fields
- Pivot table between KelasPerkuliahan and Mahasiswa
- Unique constraint on kelas_id and mahasiswa_id

#### Controller: KelasMahasiswaController
- Methods: index, trash, store, update, destroy, restore
- Validation rules for all fields
- SweetAlert notifications
- Implementation based on `RuanganController.php`
- Authentication middleware protection
- Proper error handling with try-catch blocks
- Flash messages for user feedback
- Validation for unique constraint on kelas_id and mahasiswa_id

#### View: kelas-mahasiswa-index.blade.php
- DataTables implementation
- Form for create/update with additional fields
- Delete/restore functionality
- Implementation based on `ruangan-index.blade.php`
- Bootstrap 5 components
- Responsive design
- Select2 or similar for kelas and mahasiswa selection

## Implementation Files

### TahunAkademikController.php

The controller will be created at `app/Http/Controllers/Master/Akademik/TahunAkademikController.php` and will follow the pattern established in `RuanganController.php`:

```php
<?php

namespace AppHttpControllersMasterAkademik;

use AppHttpControllersController;
use IlluminateHttpRequest;
use IlluminateSupportFacadesAuth;
use RealRashidSweetAlertFacadesAlert;
// Use Models
use AppModelsAkademikTahunAkademik;
use AppModelsPengaturanSystem;
use AppModelsPengaturanKampus;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Tahun Akademik';
        $data['pages'] = "Halaman Data Tahun Akademik";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['tahunAkademiks'] = TahunAkademik::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.akademik.tahun-akademik-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Tahun Akademik';
        $data['pages'] = "Halaman Data Tahun Akademik yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['tahunAkademiks'] = TahunAkademik::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('master.akademik.tahun-akademik-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:tahun_akademik,code',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'required|boolean'
        ], [
            'name.required' => 'Nama tahun akademik wajib diisi',
            'code.required' => 'Kode tahun akademik wajib diisi',
            'code.unique' => 'Kode tahun akademik sudah ada',
            'semester.required' => 'Semester wajib dipilih',
            'semester.in' => 'Semester tidak valid',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            TahunAkademik::create([
                'name' => $request->name,
                'code' => $request->code,
                'semester' => $request->semester,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_active' => $request->is_active,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data tahun akademik berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:tahun_akademik,code,' . $id,
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'required|boolean'
        ], [
            'name.required' => 'Nama tahun akademik wajib diisi',
            'code.required' => 'Kode tahun akademik wajib diisi',
            'code.unique' => 'Kode tahun akademik sudah ada',
            'semester.required' => 'Semester wajib dipilih',
            'semester.in' => 'Semester tidak valid',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            $tahunAkademik->update([
                'name' => $request->name,
                'code' => $request->code,
                'semester' => $request->semester,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_active' => $request->is_active,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data tahun akademik berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $tahunAkademik = TahunAkademik::findOrFail($id);

            $user = Auth::user();
            $tahunAkademik->update(['deleted_by' => $user->id]);
            $tahunAkademik->delete();

            Alert::success('Berhasil', 'Data tahun akademik berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $tahunAkademik = TahunAkademik::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $tahunAkademik->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $tahunAkademik->restore();

            Alert::success('Berhasil', 'Data tahun akademik berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}
```

### tahun-akademik-index.blade.php

The view will be created at `resources/views/master/akademik/tahun-akademik-index.blade.php` and will follow the pattern established in `ruangan-index.blade.php`:

```blade
@extends('themes.core-backpage')

@section('custom-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Stats cards */
        .bg-light-primary {
            background-color: rgba(67, 94, 190, 0.1);
        }
        
        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1);
        }
        
        .bg-light-warning {
            background-color: rgba(255, 193, 7, 0.1);
        }
        
        .bg-light-info {
            background-color: rgba(23, 162, 184, 0.1);
        }

        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 10px;
        }

        .card-header {
            background: none;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        /* Form styling */
        .form-control, .form-select {
            border-radius: 5px;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 0.5rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #435ebe;
            box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.25);
        }

        /* Badge styling */
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }

        /* Collapsible form */
        .collapse {
            transition: all 0.3s ease;
        }

        .collapse.show {
            margin-top: 1rem;
        }

        /* SECTION TABLE SUPER */

        table {
            margin: 0;
            padding: 0;
            table-layout: fixed;
        }

        table tr {
            border: 1px solid #ddd;
        }

        table th,
        table td {
            padding: 0.625em;
            text-align: center;
        }

        table th {
            font-size: 0.85em;
            text-align: center !important;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        @media screen and (max-width: 600px) {
            table {
                border: 0;
            }

            table caption {
                font-size: 1.3em;
            }

            table thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            table tr {
                border-bottom: 3px solid #ddd;
                display: block;
                margin-bottom: 0.625em;
            }

            table td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: 0.8em;
                text-align: right;
            }

            table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }

            table td:last-child {
                border-bottom: 0;
            }
            
            /* Improve delete info display on mobile */
            table td[data-label="Dihapus Oleh"] .d-flex.align-items-center,
            table td[data-label="Dihapus Pada"] .d-flex.align-items-center {
                align-items: flex-end !important;
                justify-content: flex-end !important;
            }
            
            /* Make delete info more compact on mobile */
            table td[data-label="Dihapus Pada"] div {
                text-align: right;
            }
        }
        
        /* DataTables Buttons Styling */
        .dt-buttons {
            margin-bottom: 1rem;
        }
        
        .dt-buttons .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        /* Custom DataTables styling */
        #tahunAkademikTable_wrapper .row:first-child {
            margin-bottom: 1rem;
        }
        
        .dataTables_filter input {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
        }
        
        .dataTables_length select {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
        }
        
        /* Custom toolbar styling */
        .dataTables-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .export-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .entries-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        @media (max-width: 768px) {
            .dataTables-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .export-buttons {
                justify-content: center;
            }
            
            .entries-filter {
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-primary">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Tahun Akademik</h6>
                            <h3 class="mt-2 mb-0">{{ count($tahunAkademiks) }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-primary text-white">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-success">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Aktif</h6>
                            <h3 class="mt-2 mb-0">{{ $tahunAkademiks->where('is_active', true)->count() }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-success text-white">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-warning">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Ganjil</h6>
                            <h3 class="mt-2 mb-0">{{ $tahunAkademiks->where('semester', 'Ganjil')->count() }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-warning text-white">
                            <i class="fas fa-arrow-left fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-light-info">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Genap</h6>
                            <h3 class="mt-2 mb-0">{{ $tahunAkademiks->where('semester', 'Genap')->count() }}</h3>
                        </div>
                        <div class="rounded-circle p-3 bg-info text-white">
                            <i class="fas fa-arrow-right fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-12 col-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $pages ?? 'Daftar Tahun Akademik' }}</h5>
                    <div>
                        @if($is_trash)
                            <a href="{{ route('akademik.tahun-akademik-index') }}" class="btn btn-sm btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Utama
                            </a>
                        @else
                            <a href="{{ route('akademik.tahun-akademik-trash') }}" class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-trash me-2"></i>Trash
                            </a>
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Tahun Akademik
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Collapsible Form -->
                    @if(!$is_trash)
                        <div class="collapse" id="collapseForm">
                            <div class="card card-body border">
                                <h5 class="card-title mb-3">Tambah Tahun Akademik Baru</h5>
                                <form action="{{ route('akademik.tahun-akademik-store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nama Tahun Akademik</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama tahun akademik" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="code" class="form-label">Kode Tahun Akademik</label>
                                            <input type="text" class="form-control" name="code" id="code" placeholder="Masukkan kode tahun akademik" required>
                                            @error('code')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="semester" class="form-label">Semester</label>
                                            <select class="form-select" name="semester" id="semester" required>
                                                <option value="">Pilih Semester</option>
                                                <option value="Ganjil">Ganjil</option>
                                                <option value="Genap">Genap</option>
                                                <option value="Pendek">Pendek</option>
                                            </select>
                                            @error('semester')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required>
                                            @error('tanggal_mulai')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" required>
                                            @error('tanggal_selesai')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="is_active" class="form-label">Status Aktif</label>
                                            <select class="form-select" name="is_active" id="is_active" required>
                                                <option value="1">Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            </select>
                                            @error('is_active')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tahunAkademikTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th>Semester</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tahunAkademiks as $index => $item)
                                    <tr>
                                        <td data-label="No">{{ $index + 1 }}</td>
                                        <td data-label="Nama">{{ $item->name }}</td>
                                        <td data-label="Kode">{{ $item->code }}</td>
                                        <td data-label="Semester">{{ $item->semester }}</td>
                                        <td data-label="Tanggal Mulai">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</td>
                                        <td data-label="Tanggal Selesai">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}</td>
                                        <td data-label="Status">
                                            @if($item->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td data-label="Aksi">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if(!$is_trash)
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editData{{ $item->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $item->id }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $item->id }}" action="{{ route('akademik.tahun-akademik-destroy', $item->id) }}" method="POST" style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-success" onclick="confirmRestore('{{ $item->id }}')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                    <form id="restore-form-{{ $item->id }}" action="{{ route('akademik.tahun-akademik-restore', $item->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @if(!$is_trash)
        @foreach ($tahunAkademiks as $item)
            <div class="modal fade" id="editData{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('akademik.tahun-akademik-update', $item->id) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Tahun Akademik - {{ $item->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_name{{ $item->id }}" class="form-label">Nama Tahun Akademik</label>
                                        <input type="text" class="form-control" name="name" id="edit_name{{ $item->id }}" value="{{ $item->name }}" placeholder="Masukkan nama tahun akademik" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_code{{ $item->id }}" class="form-label">Kode Tahun Akademik</label>
                                        <input type="text" class="form-control" name="code" id="edit_code{{ $item->id }}" value="{{ $item->code }}" placeholder="Masukkan kode tahun akademik" required>
                                        @error('code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_semester{{ $item->id }}" class="form-label">Semester</label>
                                        <select class="form-select" name="semester" id="edit_semester{{ $item->id }}" required>
                                            <option value="">Pilih Semester</option>
                                            <option value="Ganjil" {{ $item->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                            <option value="Genap" {{ $item->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                            <option value="Pendek" {{ $item->semester == 'Pendek' ? 'selected' : '' }}>Pendek</option>
                                        </select>
                                        @error('semester')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_tanggal_mulai{{ $item->id }}" class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control" name="tanggal_mulai" id="edit_tanggal_mulai{{ $item->id }}" value="{{ $item->tanggal_mulai }}" required>
                                        @error('tanggal_mulai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_tanggal_selesai{{ $item->id }}" class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control" name="tanggal_selesai" id="edit_tanggal_selesai{{ $item->id }}" value="{{ $item->tanggal_selesai }}" required>
                                        @error('tanggal_selesai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="edit_is_active{{ $item->id }}" class="form-label">Status Aktif</label>
                                        <select class="form-select" name="is_active" id="edit_is_active{{ $item->id }}" required>
                                            <option value="1" {{ $item->is_active ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('is_active')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@section('custom-js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#tahunAkademikTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                "responsive": true,
                "dom": '<"dataTables-toolbar"<"export-buttons"B><"entries-filter"l>f>rtip',
                "buttons": [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Salin',
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Cetak',
                        className: 'btn btn-primary btn-sm'
                    }
                ]
            });
        });

        // Konfirmasi delete dengan SweetAlert
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data tahun akademik yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Konfirmasi restore dengan SweetAlert
        function confirmRestore(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data tahun akademik akan dipulihkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, pulihkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('restore-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
```
## Deployment Considerations

When deploying the academic modules, consider the following:

1. **Database Migrations**: Ensure all migrations are run on the production database.
2. **Seeder Data**: Run the AkademikSeeder to populate initial data.
3. **Storage Links**: Create symbolic links for file storage.
4. **Environment Configuration**: Update `.env` file with production settings.
5. **Caching**: Clear and rebuild caches after deployment.
6. **Permissions**: Ensure proper file and directory permissions.
7. **Backup**: Create database backups before deployment.

Deployment commands:
```bash
php artisan migrate --force
php artisan db:seed --class=AkademikSeeder
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Future Enhancements

After the initial implementation, several enhancements could be considered:

1. **API Integration**: Create RESTful APIs for mobile applications and external integrations.
2. **Advanced Reporting**: Implement detailed analytics and reporting features.
3. **Notification System**: Add email and SMS notifications for important academic events.
4. **Import/Export Functionality**: Allow bulk data import/export in various formats.
5. **Audit Trail**: Implement comprehensive audit logging for all changes.
6. **Role-Based Access Control**: Enhance permissions system for different user roles.
7. **Multi-language Support**: Add support for multiple languages.
8. **Performance Optimization**: Implement caching and database optimization techniques.

## Conclusion

This implementation plan provides a comprehensive roadmap for developing the academic modules based on the migration file. By following existing patterns in the system, we ensure consistency and maintainability while implementing all necessary functionality for academic management. The modular approach allows for independent development and testing of each component while maintaining proper relationships between entities.