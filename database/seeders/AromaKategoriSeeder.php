<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AromaKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('aroma_kategori')->insert([
            ['nama' => 'Citrus', 'icon' => 'ph-sun-dim', 'gambar' => 'citrus.jpeg'],
            ['nama' => 'Green', 'icon' => 'ph-leaf', 'gambar' => 'green.jpeg'],
            ['nama' => 'Watery', 'icon' => 'ph-drop', 'gambar' => 'watery.jpg'],
            ['nama' => 'Aromatic Fougere', 'icon' => 'ph-wind', 'gambar' => 'aromatic-fougere.jpg'],
            ['nama' => 'Aldehydic', 'icon' => 'ph-sparkle', 'gambar' => 'aldehydic.jpg'],
            ['nama' => 'Floral', 'icon' => 'ph-flower', 'gambar' => 'floral.jpeg'],
            ['nama' => 'Fruity', 'icon' => 'ph-cherries', 'gambar' => 'fruity.jpg'],
            ['nama' => 'Spicy', 'icon' => 'ph-flame', 'gambar' => 'spicy.jpg'],
            ['nama' => 'Woody', 'icon' => 'ph-tree', 'gambar' => 'woody.jpg'],
            ['nama' => 'Chypre', 'icon' => 'ph-mountains', 'gambar' => 'chypre.jpg'],
            ['nama' => 'Tobacco', 'icon' => 'ph-fire', 'gambar' => 'tobacco.jpeg'],
            ['nama' => 'Gourmand', 'icon' => 'ph-cookie', 'gambar' => 'gourmand.jpg'],
            ['nama' => 'Ambery (Oriental)', 'icon' => 'ph-sketch-logo', 'gambar' => 'ambery.jpeg'],
            ['nama' => 'Leather', 'icon' => 'ph-wallet', 'gambar' => 'leather.jpeg'],
            ['nama' => 'Musk Skin', 'icon' => 'ph-hand-heart', 'gambar' => 'musk.jpg'],
            ['nama' => 'Conceptual', 'icon' => 'ph-magic-wand', 'gambar' => 'conceptual.jpg'],
        ]);
    }
}
