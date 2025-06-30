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
            [
                'nama' => 'Citrus',
                'icon' => 'ph-sun-dim',
                'gambar' => 'citrus.jpeg',
                'deskripsi' => 'Bright, fresh, and energizing. Citrus scents capture the zesty notes of lemon, bergamot, and orange, giving a clean and invigorating feel. Perfect for a sunny, cheerful personality.'
            ],
            [
                'nama' => 'Green',
                'icon' => 'ph-leaf',
                'gambar' => 'green.jpeg',
                'deskripsi' => 'Clean, leafy, and natural. Green scents evoke the smell of freshly cut grass, crushed leaves, and green herbs. Ideal for those who love a crisp and outdoorsy fragrance.'
            ],
            [
                'nama' => 'Watery',
                'icon' => 'ph-drop',
                'gambar' => 'watery.jpg',
                'deskripsi' => 'Cool, aquatic, and breezy. Watery scents resemble ocean waves and dewy freshness, offering a calming, subtle character that feels effortlessly elegant.'
            ],
            [
                'nama' => 'Aromatic Fougere',
                'icon' => 'ph-wind',
                'gambar' => 'aromatic-fougere.jpg',
                'deskripsi' => 'Classic, herbaceous, and masculine. This family combines lavender, oakmoss, and coumarin to give a fresh barbershop feel. A timeless pick for refined confidence.'
            ],
            [
                'nama' => 'Aldehydic',
                'icon' => 'ph-sparkle',
                'gambar' => 'aldehydic.jpg',
                'deskripsi' => 'Sparkling, abstract, and airy. Aldehydic fragrances feel clean and powdery with a unique brightness that lifts the entire composition—perfect for a sophisticated aura.'
            ],
            [
                'nama' => 'Floral',
                'icon' => 'ph-flower',
                'gambar' => 'floral.jpeg',
                'deskripsi' => 'Romantic, soft, and elegant. Floral scents are timeless, with notes like rose, jasmine, and lily—ideal for anyone who loves femininity and classic beauty.'
            ],
            [
                'nama' => 'Fruity',
                'icon' => 'ph-cherries',
                'gambar' => 'fruity.jpg',
                'deskripsi' => 'Juicy, sweet, and playful. Fruity scents capture the vibrant essence of berries, peaches, and tropical fruits—great for a youthful, fun-loving personality.'
            ],
            [
                'nama' => 'Spicy',
                'icon' => 'ph-flame',
                'gambar' => 'spicy.jpg',
                'deskripsi' => 'Warm, exotic, and bold. Spicy notes like cinnamon, clove, and pepper add intrigue and sensuality to any perfume—perfect for a confident presence.'
            ],
            [
                'nama' => 'Woody',
                'icon' => 'ph-tree',
                'gambar' => 'woody.jpg',
                'deskripsi' => 'Earthy, deep, and grounded. Woody fragrances use notes like sandalwood, cedar, and vetiver—ideal for those who value calm strength and stability.'
            ],
            [
                'nama' => 'Chypre',
                'icon' => 'ph-mountains',
                'gambar' => 'chypre.jpg',
                'deskripsi' => 'Elegant, mysterious, and rich. Chypre blends citrus top notes with mossy and woody bases, creating a complex and captivating signature.'
            ],
            [
                'nama' => 'Tobacco',
                'icon' => 'ph-fire',
                'gambar' => 'tobacco.jpeg',
                'deskripsi' => 'Smoky, sweet, and sensual. Tobacco-inspired scents blend rich leaves with honey, spices, or vanilla, giving a deep, inviting impression.'
            ],
            [
                'nama' => 'Gourmand',
                'icon' => 'ph-cookie',
                'gambar' => 'gourmand.jpg',
                'deskripsi' => 'Delicious, cozy, and irresistible. Gourmand scents smell like desserts—think vanilla, chocolate, and caramel—perfect for a comforting, warm personality.'
            ],
            [
                'nama' => 'Ambery (Oriental)',
                'icon' => 'ph-sketch-logo',
                'gambar' => 'ambery.jpeg',
                'deskripsi' => 'Rich, sensual, and exotic. Ambery fragrances combine spices, resins, and vanilla for a warm and luxurious experience that lingers beautifully.'
            ],
            [
                'nama' => 'Leather',
                'icon' => 'ph-wallet',
                'gambar' => 'leather.jpeg',
                'deskripsi' => 'Strong, smoky, and refined. Leather scents bring a touch of rebellion and class with rugged suede, birch tar, and smoky accents.'
            ],
            [
                'nama' => 'Musk Skin',
                'icon' => 'ph-hand-heart',
                'gambar' => 'musk.jpeg',
                'deskripsi' => 'Soft, skin-like, and intimate. Musk notes enhance natural body warmth, perfect for a subtle and close-to-skin scent trail.'
            ],
            [
                'nama' => 'Conceptual',
                'icon' => 'ph-magic-wand',
                'gambar' => 'conceptual.jpg',
                'deskripsi' => 'Creative, abstract, and avant-garde. Conceptual scents defy categories, blending unexpected elements into a truly artistic olfactory experience.'
            ],
        ]);
    }
}
