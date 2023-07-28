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
        Schema::create('penagihan', function (Blueprint $table) {
            $table->ulid('id_penagihan')->primary();
            $table->string('keperluan');

            $table->string('nomor_sp2d')->nullable();
            $table->date('tanggal_sp2d')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_cair')->nullable();
            
            $table->decimal('potongan_ppn', 12, 2)->nullable();
            $table->decimal('potongan_pph', 12, 2)->nullable();
            $table->decimal('potongan_lainnya', 12, 2)->nullable();
            $table->text('keterangan_potongan_lainnya')->nullable();

            $table->enum('kas_masuk', ['Utang', 'Setoran Modal']);
            $table->enum('status_penagihan', [100, 400])->default(100);
            $table->enum('status_aktivitas', ['Dibuat', 'Diajukan', 'Diterima'])->default('Dibuat');
            
            $table->foreignUlid('id_proyek');
            $table->foreignUlid('id_rekening');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penagihan');
    }
};
