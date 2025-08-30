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
        Schema::create('peminjaman_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_inventaris_id')->constrained('barang_inventaris');
            $table->foreignId('peminjam_id')->constrained('users'); 
            $table->foreignId('petugas_id')->constrained('users');

            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->dateTime('tanggal_dikembalikan')->nullable();

            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Hilang', 'Rusak'])->default('Dipinjam');
            $table->text('keterangan')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('pengecekan_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_inventaris_id')->constrained('barang_inventaris');
            $table->foreignId('petugas_id')->constrained('users'); // yang melakukan pengecekan

            $table->date('tanggal_cek');
            $table->enum('hasil_kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang']);
            $table->text('catatan')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('pengajuan_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_inventaris_id')->constrained('barang_inventaris');
            $table->foreignId('pengaju_id')->constrained('users'); // siapa yang lapor
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users'); // siapa yang acc

            $table->date('tanggal_pengajuan');
            $table->enum('status', ['Diajukan', 'Disetujui', 'Ditolak', 'Diproses', 'Selesai'])->default('Diajukan');
            $table->text('deskripsi_kerusakan')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('riwayat_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->nullable()->constrained('pengajuan_perbaikan');
            $table->foreignId('barang_inventaris_id')->constrained('barang_inventaris');

            $table->date('tanggal_service');
            $table->date('tanggal_selesai')->nullable();
            $table->string('tempat_service')->nullable(); // vendor / bengkel / internal
            $table->decimal('biaya', 15, 2)->nullable();

            $table->enum('hasil', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Tidak Bisa Diperbaiki'])->default('Baik');
            $table->text('catatan')->nullable();

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
        Schema::dropIfExists('peminjaman_barang');
        Schema::dropIfExists('pengecekan_barang');
        Schema::dropIfExists('pengajuan_perbaikan');
        Schema::dropIfExists('riwayat_perbaikan');
    }
};
