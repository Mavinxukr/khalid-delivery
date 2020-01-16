<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product\Product::create([
            'title' => 'omar',
            'description' => 'good dish',
            'type' => 'food',
            'price' => 1000,
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/0/0b/KreeftbijDenOsse.jpg',
            'has_ingredients' => false,
            'provider_id' => 1,
            'parent_id' => null
        ]);
        \App\Models\Product\Product::create([
            'title' => 'omar122',
            'description' => 'good dish',
            'type' => 'food',
            'price' => 88,
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/0/0b/KreeftbijDenOsse.jpg',
            'has_ingredients' => false,
            'provider_id' => 1,
            'parent_id' => null
        ]);
        \App\Models\Product\Product::create([
            'title' => 'cleaning flat',
            'description' => 'cleaning flat',
            'type' => 'service',
            'price' => 117,
            'image' => 'https://static.tildacdn.com/tild6332-6137-4161-b264-386564616564/good-service-logoweb.png',
            'has_ingredients' => false,
            'provider_id' => 2,
            'parent_id' => null
        ]);
        \App\Models\Product\Product::create([
            'title' => 'cleaning house',
            'description' => 'cleaning house',
            'type' => 'service',
            'price' => 333,
            'image' => 'https://static.tildacdn.com/tild6332-6137-4161-b264-386564616564/good-service-logoweb.png',
            'has_ingredients' => false,
            'provider_id' => 2,
            'parent_id' => null
        ]);

        \App\Models\Product\Product::create([
            'title' => 'cleaning flat',
            'description' => 'mean pork',
            'type' => 'market',
            'price' => 123,
            'image' => 'http://saechka.ru/upload/iblock/28a/myaso_govyadina.jpg',
            'has_ingredients' => false,
            'provider_id' => 3,
            'parent_id' => null
        ]);
        \App\Models\Product\Product::create([
            'title' => 'cleaning flat',
            'description' => 'mean bif',
            'type' => 'market',
            'price' => 747,
            'image' => 'http://saechka.ru/upload/iblock/28a/myaso_govyadina.jpg',
            'has_ingredients' => false,
            'provider_id' => 3,
            'parent_id' => null
        ]);
    }
}
