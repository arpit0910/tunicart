<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;

class DemoProductSeeder extends Seeder
{
    public function run()
    {
        $size = Attribute::firstOrCreate(['name' => 'Size']);
        foreach (['S', 'M', 'L', 'XL'] as $v) {
            AttributeValue::firstOrCreate(['attribute_id' => $size->id, 'value' => $v]);
        }

        $color = Attribute::firstOrCreate(['name' => 'Color']);
        foreach (['Black', 'White', 'Navy Blue'] as $v) {
            AttributeValue::firstOrCreate(['attribute_id' => $color->id, 'value' => $v]);
        }

        $p1 = Product::updateOrCreate(['slug' => 'premium-black-tee'], [
            'name' => 'Premium Black Tee',
            'price' => 799,
            'category_id' => 1,
            'description' => 'A premium quality 100% cotton black t-shirt. Breathable and comfortable.',
            'image' => 'products/black_tshirt.png',
            'back_image' => 'products/black_tshirt_back.png',
            'is_featured' => true
        ]);
        $p1->attributeValues()->sync(AttributeValue::whereIn('value', ['S', 'M', 'L', 'XL', 'Black'])->pluck('id'));

        $p2 = Product::updateOrCreate(['slug' => 'custom-white-tee'], [
            'name' => 'Custom White Tee',
            'price' => 699,
            'category_id' => 1,
            'description' => 'Classic white tee, perfect for custom printing or everyday wear.',
            'image' => 'products/white_tshirt.png',
            'back_image' => 'products/white_tshirt_back.png',
            'is_featured' => true
        ]);
        $p2->attributeValues()->sync(AttributeValue::whereIn('value', ['S', 'M', 'L', 'XL', 'White'])->pluck('id'));

        $p3 = Product::updateOrCreate(['slug' => 'classic-navy-polo'], [
            'name' => 'Classic Navy Polo',
            'price' => 999,
            'category_id' => 2,
            'description' => 'Elegance meets comfort in this classic navy blue polo shirt.',
            'image' => 'products/navy_polo.png',
            'back_image' => 'products/navy_polo_back.png',
            'is_featured' => true
        ]);
        $p3->attributeValues()->sync(AttributeValue::whereIn('value', ['M', 'L', 'XL', 'Navy Blue'])->pluck('id'));

        // FAQs
        \App\Models\Faq::updateOrCreate(['question' => 'How do I upload my own design?'], [
            'answer' => 'On any product page, you\'ll see a "Customize Your T-Shirt" section. You can upload front and back designs (PNG/JPG) and add specific instructions in the notes field.'
        ]);
        \App\Models\Faq::updateOrCreate(['question' => 'What is the shipping time?'], [
            'answer' => 'We typically deliver within 5-7 business days across India. Custom printed orders might take an additional 2 days for processing.'
        ]);

        // Testimonials
        \App\Models\Testimonial::updateOrCreate(['user_name' => 'Rahul Sharma'], [
            'content' => 'The print quality is amazing! The colors are vibrant and the fabric is very comfortable.',
            'rating' => 5,
            'image' => 'testimonials/user1.jpg'
        ]);
        \App\Models\Testimonial::updateOrCreate(['user_name' => 'Anita Desai'], [
            'content' => 'Ordered a custom polo for my husband. He loved the fit and the embroidery was perfect.',
            'rating' => 5,
            'image' => 'testimonials/user2.jpg'
        ]);
    }
}
