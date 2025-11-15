<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'KKM Official Tee — Black',
                'sku' => 'kkm-tee-01',
                'price' => 199000,
                'image' => 'assets/tee.jpg',
                'sizes' => 'S,M,L,XL',
                'tags' => 'shirt,tee,clothing',
                'stock' => 54,
                'rating' => 4.5,
                'description' => 'Kaos resmi tim KKM dengan sablon berkualitas tinggi dan bahan katun combed 24s. Desain minimalis dengan logo KKM.'
            ],
            [
                'name' => 'KKM Hoodie — Grey',
                'sku' => 'kkm-hood-01',
                'price' => 349000,
                'image' => 'assets/hoddie.jpg',
                'sizes' => 'M,L,XL',
                'tags' => 'hoodie,clothing',
                'stock' => 21,
                'rating' => 4.7,
                'description' => 'Hoodie tebal nyaman untuk fans KKM — logo bordir di dada kiri.'
            ],
            [
                'name' => 'KKM Snapback Cap — Black',
                'sku' => 'kkm-cap-01',
                'price' => 129000,
                'image' => 'assets/cap.jpg',
                'sizes' => 'One Size',
                'tags' => 'cap,accessories',
                'stock' => 120,
                'rating' => 4.2,
                'description' => 'Snapback dengan patch logo KKM, adjustable, cocok untuk daily wear.'
            ],
            [
                'name' => 'KKM Mug — White',
                'sku' => 'kkm-mug-01',
                'price' => 79000,
                'image' => 'assets/mug.jpg',
                'sizes' => '300ml',
                'tags' => 'mug,accessories',
                'stock' => 75,
                'rating' => 4.0,
                'description' => 'Mug keramik 300ml dengan logo KKM, aman untuk microwave.'
            ],
            [
                'name' => 'KKM Jacket — Black',
                'sku' => 'kkm-jaket',
                'price' => 88000,
                'image' => 'assets/jaket.jpg',
                'sizes' => '60%,75%,TKL',
                'tags' => 'another',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Jaket tebal.'
            ],
            [
                'name' => 'KKM Shirt — White',
                'sku' => 'kkm-shirt',
                'price' => 900000,
                'image' => 'assets/shirt.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'shirt',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Shirt keren banget pokoknya.'
            ],
            [
                'name' => 'KKM Thumbler',
                'sku' => 'kkm-thumbler',
                'price' => 67000,
                'image' => 'assets/thumbler.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'accessories',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Thumbler keren bat pokoknya.'
            ],
            [
                'name' => 'KKM Deskmat',
                'sku' => 'kkm-daskmat',
                'price' => 67000,
                'image' => 'assets/daskmat.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'accessories',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Deskmat keren bat pokoknya.'
            ],
            [
                'name' => 'KKM Keychain',
                'sku' => 'kkm-keychain',
                'price' => 67000,
                'image' => 'assets/gantungan.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'accessories',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Keychain keren bat pokoknya.'
            ],
            [
                'name' => 'KKM Tote Bag',
                'sku' => 'kkm-tote-back',
                'price' => 67000,
                'image' => 'assets/totbek.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'accessories',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Tote bag keren bat pokoknya.'
            ],
            [
                'name' => 'KKM Socks',
                'sku' => 'kkm-socks',
                'price' => 67000,
                'image' => 'assets/kaos kaki.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'accessories',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Kaos kaki keren bat pokoknya.'
            ],
            [
                'name' => 'KKM Kemeja',
                'sku' => 'kkm-kemeja',
                'price' => 67000,
                'image' => 'assets/kemeja.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'accessories',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Kemeja keren bat pokoknya.'
            ],
            [
                'name' => 'KKM Keyboard',
                'sku' => 'kkm-keyboard',
                'price' => 67000,
                'image' => 'assets/keyboard.jpg',
                'sizes' => 'L,XL,XXL',
                'tags' => 'another',
                'stock' => 67,
                'rating' => 4.0,
                'description' => 'Keyboard keren bat pokoknya.'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
