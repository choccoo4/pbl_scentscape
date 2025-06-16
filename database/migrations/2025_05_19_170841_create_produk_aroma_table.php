`<?php

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
        Schema::create('produk_aroma', function (Blueprint $table) {
            $table->unsignedBigInteger('no_produk');
            $table->unsignedBigInteger('id_kategori');

            $table->primary(['no_produk', 'id_kategori']);
            $table->foreign('no_produk')->references('no_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('aroma')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_aroma');
    }
};
