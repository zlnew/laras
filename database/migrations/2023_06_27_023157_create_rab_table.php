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
        Schema::create('rab', function (Blueprint $table) {
            $table->ulid('id_rab')->primary();
            $table->decimal('tax', 5, 2)->default(11);
            $table->decimal('additional_tax', 5, 2)->default(4);
            $table->enum('status_rab', [100, 400])->default(100);
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
        Schema::dropIfExists('rab');
    }
};
