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
        Schema::create('proyek', function (Blueprint $table) {
            $table->ulid('id_proyek')->primary();
            $table->string('nama_proyek');
            $table->string('nomor_kontrak', 25);
            $table->date('tanggal_kontrak');
            $table->decimal('nilai_kontrak', 12, 2, true);

            $table->string('pengguna_jasa', 128);
            $table->string('penyedia_jasa', 128);
            $table->year('tahun_anggaran');

            $table->string('nomor_spmk');
            $table->string('tanggal_spmk');

            $table->date('tanggal_mulai');
            $table->unsignedInteger('durasi');
            $table->date('tanggal_selesai');
            
            $table->enum('status_proyek', [100, 400])->default(100);
            $table->foreignId('id_user');
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
        Schema::dropIfExists('proyek');
    }
};
