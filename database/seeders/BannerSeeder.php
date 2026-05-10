<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run()
    {
        Banner::truncate();

        Banner::create([
            'title' => 'Design Your Legacy',
            'image' => 'banners/creator.png',
            'sub_title' => 'The Ultimate Creator Series',
            'description' => 'Unleash your creativity with our high-definition oversized t-shirts. Engineered for comfort, designed for expression.',
            'button_text' => 'Launch Creator',
            'text_color' => '#ffffff',
            'link' => '/products'
        ]);

        Banner::create([
            'title' => 'Elegance in Every Stitch',
            'image' => 'banners/luxe.png',
            'sub_title' => 'The Luxe Minimalist Collection',
            'description' => 'Discover the premium bio-washed series. Ultra-soft fabric meets sophisticated design for your everyday luxury.',
            'button_text' => 'View Collection',
            'text_color' => '#1E0E00',
            'link' => '/products'
        ]);

        Banner::create([
            'title' => 'Unity in Design',
            'image' => 'banners/bulk.png',
            'sub_title' => 'Corporate & Bulk Solutions',
            'description' => 'High-quality custom apparel for teams, startups, and events. Get dedicated support and exclusive bulk pricing.',
            'button_text' => 'Get a Quote',
            'text_color' => '#1E0E00',
            'link' => '/contact'
        ]);
    }
}
