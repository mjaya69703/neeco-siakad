<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->enum('semester', ['Ganjil', 'Genap', 'Pendek'])->default('Ganjil');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('is_active')->default('false');

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('fakultas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->string('nama_singkat', 20)->nullable();

            // Legal & administrasi
            $table->string('akreditasi', 10)->nullable();
            $table->date('tanggal_akreditasi')->nullable();
            $table->string('sk_pendirian')->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();

            // Relasi pejabat
            $table->foreignId('dekan_id')->nullable()->constrained('users');
            $table->foreignId('sekretaris_id')->nullable()->constrained('users');

            // Kontak
            $table->string('email')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            
            $table->boolean('is_active')->default('true');

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('fakultas_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas');
            $table->string('slug')->unique();

            // Konten
            $table->longText('deskripsi')->nullable();
            $table->longText('objektif')->nullable();
            $table->longText('karir')->nullable();

            // Banner / Logo
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('program_studi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas');

            $table->string('name');
            $table->string('code', 10)->unique();
            $table->string('nama_singkat', 20)->nullable();

            // Legal & administrasi
            $table->string('akreditasi', 10)->nullable();
            $table->date('tanggal_akreditasi')->nullable();
            $table->string('sk_pendirian')->nullable();
            $table->date('tanggal_sk_pendirian')->nullable();
            
            // Gelar Lulusan & Jenjang
            $table->enum('jenjang', ['D3', 'D4', 'S1', 'S2', 'S3']);
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();

            // Relasi pejabat
            $table->foreignId('kaprodi_id')->nullable()->constrained('users');
            $table->foreignId('sekretaris_id')->nullable()->constrained('users');

            $table->boolean('is_active')->default('true');

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('program_studi_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi');
            $table->string('slug')->unique();

            // Konten
            $table->longText('deskripsi')->nullable();
            $table->longText('objektif')->nullable();
            $table->longText('karir')->nullable();

            // Banner / Logo
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('kurikulum', function (Blueprint $table) {
            $table->id();
            // Relasi inti
            $table->foreignId('program_studi_id')->constrained('program_studi');

            // Identitas kurikulum
            $table->string('name');
            $table->string('code', 20)->unique();
            $table->text('deskripsi')->nullable();

            // Periode berlaku
            $table->year('tahun_berlaku');              
            $table->year('tahun_berakhir')->nullable(); 
            $table->foreignId('awal_tahun_akademik_id')->constrained('tahun_akademik');
            $table->foreignId('akhir_tahun_akademik_id')->constrained('tahun_akademik');

            // Ketentuan akademik
            $table->integer('total_sks_lulus')->default(144);
            $table->integer('sks_wajib')->default(0);
            $table->integer('sks_pilihan')->default(0);
            $table->integer('semester_normal')->default(8);
            $table->decimal('ipk_minimal', 3, 2)->default(2.00);

            // Dokumen & status
            $table->string('sk_penetapan')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->enum('status', ['Masih Berlaku', 'Tidak Berlaku'])->default('Masih Berlaku');

            // Audit fields
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            // Relasi inti
            $table->foreignId('kurikulum_id')->constrained('kurikulum');

            // Identitas kurikulum
            $table->string('name');
            $table->string('code', 20)->unique();
            $table->text('deskripsi')->nullable();

            // Periode berlaku
            $table->year('tahun_berlaku');              
            $table->year('tahun_berakhir')->nullable(); 
            $table->foreignId('awal_tahun_akademik_id')->constrained('tahun_akademik');
            $table->foreignId('akhir_tahun_akademik_id')->constrained('tahun_akademik');

            // Ketentuan akademik
            $table->integer('total_sks_lulus')->default(144);
            $table->integer('sks_wajib')->default(0);
            $table->integer('sks_pilihan')->default(0);
            $table->integer('semester_normal')->default(8);
            $table->decimal('ipk_minimal', 3, 2)->default(2.00);

            // Dokumen & status
            $table->string('sk_penetapan')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->enum('status', ['Masih Berlaku', 'Tidak Berlaku'])->default('Masih Berlaku');

            // Audit fields
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_akademik');
        Schema::dropIfExists('fakultas');
        Schema::dropIfExists('fakultas_profile');
        Schema::dropIfExists('program_studi');
        Schema::dropIfExists('program_studi_profile');
    }
};
