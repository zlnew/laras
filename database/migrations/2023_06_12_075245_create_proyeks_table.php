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
            $table->string('tahun_anggaran', 15);
            $table->string('pengguna_jasa', 50);
            $table->decimal('nilai_kontrak', 12, 2, true);
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->string('pic', 50);
            $table->enum('status_proyek', [100, 400])->default(100);
            $table->text('slug');
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
