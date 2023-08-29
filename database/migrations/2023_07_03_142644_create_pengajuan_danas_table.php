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
        Schema::create('pengajuan_dana', function (Blueprint $table) {
            $table->ulid('id_pengajuan_dana')->primary();
            $table->string('keperluan');
            $table->enum('jenis_transaksi', ['Setoran Modal', 'Penarikan', 'Utang', 'Piutang', 'Pembayaran']);
            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->enum('status_pengajuan', [100, 400])->default(100);
            $table->enum('status_aktivitas', ['Dibuat', 'Diajukan', 'Ditolak', 'Disetujui'])->default('Dibuat');
            $table->foreignUlid('id_proyek');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_dana');
    }
};
