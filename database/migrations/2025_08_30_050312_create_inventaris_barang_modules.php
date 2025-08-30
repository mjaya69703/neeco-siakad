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
        Schema::create('kategori_barang', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('code')->unique();
            
            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_barang');
            
            $table->string('name');
            $table->string('code')->unique();
            $table->string('merk');

            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->boolean('is_active')->default(true);
            
            // Audit
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Schema::create('barang_ruangan', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('ruangan_id')->constrained('ruangan');
        //     $table->foreignId('barang_id')->constrained('barang');
            
        //     $table->integer('jumlah')->default(1);
        //     $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
        //     $table->boolean('is_active')->default(true);
            
        //     // Audit
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->unsignedBigInteger('created_by')->nullable();
        //     $table->unsignedBigInteger('updated_by')->nullable();
        //     $table->unsignedBigInteger('deleted_by')->nullable();
        // });

        Schema::create('barang_inventaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->nullable()->constrained('users');
            $table->foreignId('ruangan_id')->nullable()->constrained('ruangan');
            $table->foreignId('barang_id')->constrained('barang');

            $table->string('nomor_inventaris')->unique();
            $table->string('serial_number')->nullable()->unique();  

            // Info pembelian
            $table->date('tanggal_pembelian')->nullable();
            $table->date('tanggal_pendataan')->nullable();

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
        Schema::dropIfExists('kategori_barang');
        Schema::dropIfExists('barang');
        // Schema::dropIfExists('barang_ruangan');
        Schema::dropIfExists('barang_inventaris');
    }
};
