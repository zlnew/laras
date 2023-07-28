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
            $table->decimal('tax', 3, 2, true);
            $table->decimal('additional_tax', 3, 2, true);
            $table->enum('status_rab', [100, 400])->default(100);
            $table->enum('status_aktivitas', ['Dibuat', 'Diajukan', 'Disetujui'])->default('Dibuat');
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
