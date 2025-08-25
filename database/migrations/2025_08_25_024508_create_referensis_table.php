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
        Schema::create('agamas', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');
            $table->enum('tipe', ['ktp', 'domisili']);
            $table->text('alamat_lengkap');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota_kabupaten');
            $table->string('provinsi');
            $table->string('kode_pos');
            $table->string('rt');
            $table->string('rw');
            
            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });
        Schema::create('golongan_darahs', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });
        Schema::create('jenis_kelamins', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::create('kewarganegaraans', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });
        Schema::create('pendidikans', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');
            $table->enum('jenjang', ['Paket C', 'SMA', 'SMK', 'D3', 'S1', 'S2', 'S3'])->default('SMA');
            $table->string('nama_institusi');
            $table->string('jurusan')->nullable();
            $table->integer('tahun_masuk')->nullable();
            $table->integer('tahun_lulus')->nullable();
            $table->string('ipk')->nullable();
            $table->text('alamat')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });
        Schema::create('keluargas', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner'); 
            $table->enum('hubungan', ['Ayah', 'Ibu', 'Suami', 'Istri', 'Anak', 'Kakak', 'Adik', 'Wali'])->default('Ayah');
            $table->string('nama');
            $table->string('pekerjaan')->nullable();
            $table->string('telepon')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->bigInteger('penghasilan')->nullable();
            $table->text('alamat')->nullable();

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
        Schema::dropIfExists('agamas');
        Schema::dropIfExists('alamats');
        Schema::dropIfExists('golongan_darahs');
        Schema::dropIfExists('jenis_kelamins');
        Schema::dropIfExists('kewarganegaraans');
        Schema::dropIfExists('pendidikans');
        Schema::dropIfExists('keluargas');
    }
};
