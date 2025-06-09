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
        Schema::create('aroma', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama');
            $table->unsignedBigInteger('aroma_kategori_id')->nullable(); // FK ke induk aroma
            $table->foreign('aroma_kategori_id')->references('id')->on('aroma_kategori')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aroma');
    }
};
