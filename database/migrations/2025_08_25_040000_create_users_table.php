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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Relasi Role
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans');
            // $table->foreignId('role_id')->constrained('ref_roles')->cascadeOnDelete();
            
            $table->string('name');
            $table->string('photo')->default('default.jpg');
            $table->string('username')->nullable()->unique();

            // Detail Kontak
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('link_ig')->nullable();
            $table->string('link_fb')->nullable();
            $table->string('link_in')->nullable();

            // Nomor Identitas
            $table->string('nomor_kk')->nullable()->unique();
            $table->string('nomor_ktp')->nullable()->unique();
            $table->string('nomor_npwp')->nullable()->unique();
            

            // Biodata dasar (pakai referensi untuk konsistensi)
            $table->foreignId('agama_id')->nullable()->constrained('agamas');
            $table->foreignId('golongan_darah_id')->nullable()->constrained('golongan_darahs');
            $table->foreignId('jenis_kelamin_id')->nullable()->constrained('jenis_kelamins');
            $table->foreignId('kewarganegaraan_id')->nullable()->constrained('kewarganegaraans');

            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // Keamanan
            $table->string('code')->unique();
            $table->string('password');
            $table->boolean('fst_setup')->default(false);   // First Setup Account
            $table->boolean('tfa_setup')->default(false);   // Two Factor Authentication

            // Google auth
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
            $table->string('google_refresh_token')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
