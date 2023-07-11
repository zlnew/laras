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
            $table->foreignUlid('id_pengajuan_dana');
            $table->foreignUlid('id_detail_rap');
            $table->foreignUlid('id_rekening');
            $table->string('uraian');
            $table->decimal('jumlah_pengajuan', 12, 2);
            $table->enum('jenis_pembayaran', ['Cash', 'Transfer']);
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
