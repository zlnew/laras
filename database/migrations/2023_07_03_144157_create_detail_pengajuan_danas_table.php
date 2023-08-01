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
        Schema::create('detail_pengajuan_dana', function (Blueprint $table) {
            $table->id('id_detail_pengajuan_dana');
            $table->string('uraian');
            $table->decimal('jumlah_pengajuan', 20, 2);
            $table->enum('jenis_pembayaran', ['Cash', 'Transfer']);
            $table->enum('status_persetujuan', [100, 400])->default(100);
            $table->foreignUlid('id_pengajuan_dana');
            $table->foreignUlid('id_detail_rap');
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
        Schema::dropIfExists('detail_pengajuan_dana');
    }
};
