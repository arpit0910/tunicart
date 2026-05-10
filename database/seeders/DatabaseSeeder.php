<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Users
        $this->call(AdminUserSeeder::class);

        // 2. Categories
        $categories = [
            ['name' => 'Round Neck T-Shirts', 'slug' => 'round-neck', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Polo T-Shirts', 'slug' => 'polo', 'image' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'V-Neck T-Shirts', 'slug' => 'v-neck', 'image' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Oversized T-Shirts', 'slug' => 'oversized', 'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?auto=format&fit=crop&w=800&q=80'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Demo Products and Attributes
        $this->call(DemoProductSeeder::class);

        // 4. Banners
        $this->call(BannerSeeder::class);
    }
}
