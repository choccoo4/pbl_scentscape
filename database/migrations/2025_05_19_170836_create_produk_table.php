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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('no_produk');
            $table->string('nama_produk');
            $table->decimal('harga', 12, 0);
            $table->text('deskripsi');
            $table->integer('stok')->default(0);
            $table->string('gambar');
            $table->string('volume');
            $table->enum('label_kategori', ['Unisex', 'For Him', 'For Her', 'Gifts']);
            $table->enum('tipe_parfum', [
                'Eau De Parfum (EDP)',
                'Eau De Toilette (EDT)',
                'Body Mist',
                'Cologne',
                'Perfume Oil',
                'Solid Perfume'
            ]);
            $table->timestamp('waktu_dibuat')->useCurrent();
            $table->timestamp('waktu_diperbarui')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
