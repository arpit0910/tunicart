<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = \App\Models\Attribute::create(['name' => 'Color']);
        $size = \App\Models\Attribute::create(['name' => 'Size']);

        $color->values()->createMany([
            ['value' => 'Red'],
            ['value' => 'Blue'],
            ['value' => 'Black'],
            ['value' => 'White'],
        ]);

        $size->values()->createMany([
            ['value' => 'S'],
            ['value' => 'M'],
            ['value' => 'L'],
            ['value' => 'XL'],
            ['value' => 'XXL'],
        ]);

        // Attach all values to all products for testing
        $products = \App\Models\Product::all();
        $values = \App\Models\AttributeValue::all()->pluck('id');
        foreach ($products as $product) {
            $product->attributeValues()->sync($values);
        }
    }
}
