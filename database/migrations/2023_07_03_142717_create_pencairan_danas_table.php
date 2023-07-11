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
        Schema::create('pencairan_dana', function (Blueprint $table) {
            $table->ulid('id_pencairan_dana')->primary();
            $table->foreignUlid('id_keuangan');
            $table->enum('status_pencairan', [100, 400])->default(100);
            $table->enum('status_aktivitas', ['Dibuat', 'Dibayar', 'Diterima'])->default('Dibuat');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencairan_dana');
    }
};
