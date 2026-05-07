<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Categories
        $round_neck = \App\Models\Category::create(['name' => 'Round Neck T-Shirts', 'slug' => 'round-neck', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=80']);
        $polo = \App\Models\Category::create(['name' => 'Polo T-Shirts', 'slug' => 'polo', 'image' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&w=800&q=80']);
        $v_neck = \App\Models\Category::create(['name' => 'V-Neck T-Shirts', 'slug' => 'v-neck', 'image' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=800&q=80']);
        $oversized = \App\Models\Category::create(['name' => 'Oversized T-Shirts', 'slug' => 'oversized', 'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?auto=format&fit=crop&w=800&q=80']);

        // Products
        \App\Models\Product::create([
            'category_id' => $round_neck->id,
            'name' => 'Classic Cotton Round Neck',
            'slug' => 'classic-cotton-round-neck',
            'description' => 'Premium 100% cotton round neck t-shirt. Breathable and perfect for Indian summers.',
            'price' => 499,
            'image' => 'product-1.png',
            'is_featured' => true
        ]);

        \App\Models\Product::create([
            'category_id' => $polo->id,
            'name' => 'Royal Heritage Polo',
            'slug' => 'royal-heritage-polo',
            'description' => 'Sophisticated polo t-shirt with premium fabric and elegant fit.',
            'price' => 899,
            'image' => 'product-2.png',
            'is_featured' => true
        ]);

        \App\Models\Product::create([
            'category_id' => $oversized->id,
            'name' => 'Urban Vibes Oversized Tee',
            'slug' => 'urban-vibes-oversized',
            'description' => 'Trendy oversized fit for the modern street style enthusiast.',
            'price' => 699,
            'image' => 'product-1.png',
            'is_featured' => true
        ]);
    }
}
