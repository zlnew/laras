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
        Schema::create('detail_pencairan_dana', function (Blueprint $table) {
            $table->id('id_detail_pencairan_dana');
            $table->decimal('jumlah_pencairan', 20, 2);
            $table->enum('status_pembayaran', [100, 400])->default(100);
            $table->foreignUlid('id_pencairan_dana');
            $table->foreignUlid('id_detail_pengajuan_dana');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pencairan_dana');
    }
};
