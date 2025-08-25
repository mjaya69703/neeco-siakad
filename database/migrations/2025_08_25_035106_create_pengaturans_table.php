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
        Schema::create('systems', function (Blueprint $table) {
            $table->id();
            // Pengaturan Aplikasi
            $table->string('app_name')->default('Neco Siakad');
            $table->string('app_version')->default('1.0');
            $table->string('app_description')->default('Sistem Informasi Akademik');
            $table->string('app_url')->default('https://neco-siakad.idev-fun.org');
            $table->string('app_email')->default('info@idev-fun.org');

            // Pengaturan Logo
            $table->string('app_favicon')->default('favicon.png');
            $table->string('app_logo_vertikal')->default('logo-vertikal.png');
            $table->string('app_logo_horizontal')->default('logo-horizontal.png');

            // Pengaturan Sistem
            $table->boolean('maintenance_mode')->default(false);      // MODE MAINTENANCE
            $table->boolean('enable_captcha')->default(false);        // AKTIFKAN CAPTCHA
            $table->integer('max_login_attempts')->default(5);        // BATAS PERCOBAAN LOGIN
            $table->integer('login_decay_seconds')->default(60);      // WAKTU RESET PERCOBAAN LOGIN

            // Audit Tracking
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('kampuses', function (Blueprint $table) {
            $table->id();
            // Pengaturan Kampus
            $table->string('name')->default('Nusantara Academy');
            $table->string('phone')->default('081200000001');
            $table->string('faximile')->default('081200000002');
            $table->string('whatsapp')->default('081200000003');
            $table->string('email_info')->default('info@idev-fun.org');
            $table->string('email_humas')->default('humas@idev-fun.org');
            $table->string('domain')->default('idev-fun.org');

            // Pengaturan Lainnya
            $table->string('tahun_akademik_id')->nullable();

            // Pengaturan Logo
            $table->string('favicon')->default('favicon.png');
            $table->string('logo_vertikal')->default('logo-vertikal.png');
            $table->string('logo_horizontal')->default('logo-horizontal.png');
            
            // Lokasi Kampus
            $table->text('alamat')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota_kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('langtitude')->nullable();
            $table->string('longitude')->nullable();

            // Channel Sosial Media
            $table->string('tiktok')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('xtwitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            
            // Audit Tracking
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
        Schema::dropIfExists('systems');
        Schema::dropIfExists('kampuses');
    }
};
