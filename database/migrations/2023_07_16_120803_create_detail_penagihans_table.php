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
        Schema::create('detail_penagihan', function (Blueprint $table) {
            $table->id('id_detail_penagihan');
            $table->decimal('volume_penagihan', 5, 2);
            $table->decimal('harga_satuan_penagihan', 20, 2);
            $table->enum('status_diterima', [100, 400])->default(100);
            $table->foreignUlid('id_penagihan');
            $table->foreignUlid('id_detail_rab');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penagihan');
    }
};
