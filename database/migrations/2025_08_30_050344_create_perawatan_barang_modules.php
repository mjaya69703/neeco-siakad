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
        Schema::create('jadwal_pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_inventaris_id')->constrained('barang_inventaris');
            
            $table->enum('jenis', ['Harian', 'Mingguan', 'Bulanan', 'Tahunan']); // tipe interval
            $table->integer('interval_hari')->nullable(); 
            
            $table->date('tanggal_mulai'); // mulai berlaku
            $table->date('tanggal_berikutnya')->nullable();

            $table->text('keterangan')->nullable();

            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('histori_pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwal_pemeliharaan');
            $table->foreignId('barang_inventaris_id')->constrained('barang_inventaris');
            $table->foreignId('petugas_id')->constrained('users'); // siapa yang cek
            
            $table->date('tanggal_pelaksanaan');
            $table->enum('hasil_kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang']);
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
        Schema::dropIfExists('jadwal_pemeliharaan');
        Schema::dropIfExists('histori_pemeliharaan');
    }
};
