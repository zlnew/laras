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
            $table->timestamp('tanggal_pengajuan')->nullable();

            $table->string('nomor_sp2d');
            $table->date('tanggal_sp2d');
            $table->date('tanggal_terbit');
            $table->date('tanggal_cair');
            $table->decimal('nilai_netto', 20, 2);
            $table->binary('faktur')->nullable();
            
            $table->decimal('potongan_ppn', 20, 2)->nullable();
            $table->decimal('potongan_pph', 20, 2)->nullable();
            $table->decimal('potongan_lainnya', 20, 2)->nullable();
            $table->text('keterangan_potongan_lainnya')->nullable();

            $table->enum('status_penagihan', [100, 400])->default(100);
            $table->enum('status_aktivitas', ['Dibuat', 'Diajukan', 'Ditolak', 'Diterima Bertahap', 'Diterima'])->default('Dibuat');
            $table->decimal('jumlah_diterima', 20, 2)->default(0);
            
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
