<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => '2 in 1 Highchair/Bassinet',
                'description' => 'Elevate mealtime with ease using the highchair function of our versatile product. Featuring a secure and comfortable seat, adjustable straps, and a removable tray, it ensures your baby safety and comfort while enjoying their meals.',
                'image_url' => 'https://adenzo.co.ke/public/uploads/all/GBZW35kAmewpZC8MRBTopjbLoGz1DC6plO3T25bN.webp',
                'price' => 1300,
                'quantity' => 5,
                'category_id' => 1
            ],

            [
                'name' => 'Baby Stroller Travel System',
                'description' => 'Explore the world with ease using our Baby Stroller Travel System. Designed for convenience and comfort, this travel system includes a stroller, car seat, and adjustable canopy for sunny days.',
                'image_url' => 'https://img.freepik.com/premium-photo/talking-by-phone-mother-red-coat-have-walk-with-her-kid-pram-park-autumn-time_146671-28374.jpg?w=900',
                'price' => 299,
                'quantity' => 10,
                'category_id' => 2
            ],
            [
                'name' => 'Soft Baby Blanket Set',
                'description' => 'Wrap your little one in warmth with our Soft Baby Blanket Set. Made from premium materials, these blankets are gentle on baby\'s skin and perfect for cuddling during naptime.',
                'image_url' => 'https://img.freepik.com/free-photo/blankets-toy-carrycot_23-2147698802.jpg?w=900',
                'price' => 39,
                'quantity' => 15,
                'category_id' => 3
            ],
            [
                'name' => 'Interactive Baby Playmat',
                'description' => 'Stimulate your baby\'s senses with our Interactive Baby Playmat. Featuring colorful designs, detachable toys, and soft padding, it encourages exploration and development during playtime.',
                'image_url' => 'https://example.com/playmat.jpg',
                'price' => 49,
                'quantity' => 12,
                'category_id' => 4
            ],
            [
                'name' => 'Baby Diaper Bag Backpack',
                'description' => 'Stay organized on the go with our Baby Diaper Bag Backpack. With multiple compartments, insulated pockets, and a changing pad, it\'s the perfect companion for busy parents.',
                'image_url' => 'https://img.freepik.com/free-photo/pink-vanity-case-products_23-2149879885.jpg?w=900',
                'price' => 59,
                'quantity' => 20,
                'category_id' => 1
            ],
            [
                'name' => 'Baby Bouncer Seat',
                'description' => 'Keep your baby entertained and comfortable with our Baby Bouncer Seat. Featuring soothing vibrations, interactive toys, and a cozy seat, it\'s perfect for playtime or naptime.',
                'image_url' => 'https://img.freepik.com/premium-photo/portrait-cute-girl-sitting-wall_1048944-19035968.jpg?w=900',
                'price' => 79,
                'quantity' => 7,
                'category_id' => 3
            ],
            [
                'name' => 'Baby Bath Tub',
                'description' => 'Make bath time fun and safe with our Baby Bath Tub. Designed with a non-slip surface, built-in thermometer, and ergonomic design, it ensures a comfortable bathing experience for your little one.',
                'image_url' => 'https://img.freepik.com/free-photo/girl-playing-bathtub-front-view_23-2150084077.jpg?w=900',
                'price' => 34,
                'quantity' => 9,
                'category_id' => 4
            ],
            [
                'name' => 'Convertible Highchair',
                'description' => 'Adapt mealtime to your growing child with our Convertible Highchair. With adjustable height settings, a removable tray, and easy-to-clean materials, it\'s a practical addition to any kitchen.',
                'image_url' => 'https://img.freepik.com/free-psd/portacrib-mockup_1310-574.jpg?w=900',
                'price' => 129,
                'quantity' => 6,
                'category_id' => 2
            ],
            [
                'name' => 'Baby Monitor with Camera',
                'description' => 'Keep an eye on your little one with our Baby Monitor with Camera. Featuring night vision, two-way audio, and remote viewing capabilities, it provides peace of mind for parents day and night.',
                'image_url' => 'https://img.freepik.com/free-photo/cute-kid-with-stuffed-animal_23-2150573740.jpg?w=900',
                'price' => 149,
                'quantity' => 10,
                'category_id' => 4
            ],
            [
                'name' => 'Baby Swaddle Blanket Set',
                'description' => 'Wrap your newborn in comfort with our Baby Swaddle Blanket Set. Made from soft, breathable fabric, these swaddles promote better sleep and are gentle on delicate skin.',
                'image_url' => 'https://img.freepik.com/free-photo/cute-baby-doll-children-still-life_23-2150872413.jpg?w=740',
                'price' => 29,
                'quantity' => 8,
                'category_id' => 3
            ]
        ];


        DB::table('products')->insert($products);
    }
}
