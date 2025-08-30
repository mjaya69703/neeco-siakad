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
        Schema::create('gedung', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->text('alamat')->nullable();
            $table->integer('jumlah_lantai')->default(1);
            $table->year('tahun_dibangun')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->boolean('is_active')->default(true);
            
            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedung_id')->constrained('gedung');
            
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('jenis', ['Kelas', 'Lab', 'Auditorium', 'Kantor', 'Perpustakaan', 'Lainnya']);
            $table->integer('kapasitas');
            $table->integer('lantai')->default(1);

            // Fasilitas
            $table->boolean('is_ac')->default(false);
            $table->boolean('is_proyektor')->default(false);
            $table->boolean('is_wifi')->default(false);
            $table->boolean('is_sound_system')->default(false);
            
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->boolean('is_active')->default(true);
            
            // Audit
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
        Schema::dropIfExists('gedung');
        Schema::dropIfExists('ruangan');
    }
};
