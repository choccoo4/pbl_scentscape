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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->string('nomor_pesanan')->unique();
            $table->integer('total');
            $table->integer('ongkir')->default(0);
            $table->enum('status', ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Ditolak', 'Dikemas', 'Dikirim', 'Terkirim', 'Selesai', 'Dibatalkan']);
            $table->timestamp('waktu_pemesanan')->useCurrent();
            $table->timestamp('batas_waktu_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
