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
        Schema::create('rap', function (Blueprint $table) {
            $table->ulid('id_rap')->primary();
            $table->enum('status_rap', [100, 400])->default(100);
            $table->enum('status_aktivitas', ['Dibuat', 'Diajukan', 'Disetujui', 'Ditolak'])->default('Dibuat');
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
        Schema::dropIfExists('rap');
    }
};
