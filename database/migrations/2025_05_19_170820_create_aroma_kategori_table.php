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
        Schema::create('aroma_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('icon')->nullable();     // contoh: ph-flower
            $table->string('gambar')->nullable();   // contoh: floral.jpg
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aroma_kategori');
    }
};
