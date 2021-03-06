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
            'parent_id' => null,
            'category_id' => rand(1,4),
            'weight' => rand(115,995),
            'sort_most_selling' =>1,
            'sort_appetizers' =>0,
            'sort_sales' =>1,
        ]);
        \App\Models\Product\Product::create([
            'title' => 'omar122',
            'description' => 'good dish',
            'type' => 'food',
            'price' => 88,
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/0/0b/KreeftbijDenOsse.jpg',
            'has_ingredients' => false,
            'provider_id' => 1,
            'parent_id' => null,
            'category_id' => rand(1,4),
            'weight' => rand(115,995),
            'sort_most_selling' =>0,
            'sort_appetizers' =>1,
            'sort_sales' =>0,
        ]);
        \App\Models\Product\Product::create([
            'title' => 'omar122',
            'description' => 'good dish',
            'type' => 'food',
            'price' => 88,
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/0/0b/KreeftbijDenOsse.jpg',
            'has_ingredients' => false,
            'provider_id' => 1,
            'parent_id' => null,
            'category_id' => rand(1,4),
            'weight' => rand(115,995),
            'sort_most_selling' =>1,
            'sort_appetizers' =>1,
            'sort_sales' =>0,
        ]);
        \App\Models\Product\Product::create([
            'title' => 'pork',
            'description' => 'good dish',
            'type' => 'food',
            'price' => 32,
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/0/0b/KreeftbijDenOsse.jpg',
            'has_ingredients' => false,
            'provider_id' => 1,
            'parent_id' => null,
            'category_id' => rand(1,4),
            'weight' => rand(115,995),
            'sort_most_selling' =>0,
            'sort_appetizers' =>0,
            'sort_sales' =>1,
        ]);
        \App\Models\Product\Product::create([
            'title' => 'fish',
            'description' => 'good dish',
            'type' => 'food',
            'price' => 33,
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/0/0b/KreeftbijDenOsse.jpg',
            'has_ingredients' => false,
            'provider_id' => 1,
            'parent_id' => null,
            'category_id' => rand(1,4),
            'weight' => rand(115,995),
            'sort_most_selling' =>0,
            'sort_appetizers' =>0,
            'sort_sales' =>1,
        ]);




        \App\Models\Product\Product::create([
            'title' => 'cleaning flat',
            'description' => 'cleaning flat',
            'type' => 'service',
            'price' => 117,
            'image' => 'https://static.tildacdn.com/tild6332-6137-4161-b264-386564616564/good-service-logoweb.png',
            'has_ingredients' => false,
            'provider_id' => 2,
            'parent_id' => null,
            'what_is_included' => ["First include","Second include"],
            'what_is_not_included' => "First exnclude,Second exnclude",
        ]);
        \App\Models\Product\Product::create([
            'title' => 'cleaning house',
            'description' => 'cleaning house',
            'type' => 'service',
            'price' => 333,
            'image' => 'https://static.tildacdn.com/tild6332-6137-4161-b264-386564616564/good-service-logoweb.png',
            'has_ingredients' => false,
            'provider_id' => 2,
            'parent_id' => null,
            'what_is_included' => ["First include","Second include"],
            'what_is_not_included' => "First exnclude,Second exnclude",
        ]);


        \App\Models\Product\Product::create([
            'title' => 'market mean',
            'description' => 'mean pork',
            'type' => 'market',
            'price' => 123,
            'image' => 'http://saechka.ru/upload/iblock/28a/myaso_govyadina.jpg',
            'has_ingredients' => false,
            'provider_id' => 3,
            'parent_id' => null,
            'category_id' => rand(5,7),
            'weight' => rand(115,995)

        ]);
        \App\Models\Product\Product::create([
            'title' => 'market mean123',
            'description' => 'mean bif',
            'type' => 'market',
            'price' => 747,
            'image' => 'http://saechka.ru/upload/iblock/28a/myaso_govyadina.jpg',
            'has_ingredients' => false,
            'provider_id' => 3,
            'parent_id' => null,
            'category_id' => rand(5,7),
            'weight' => rand(115,995)

        ]);
        \App\Models\Product\Product::create([
            'title' => 'market mean123',
            'description' => 'mean bif',
            'type' => 'market',
            'price' => 323,
            'image' => 'http://saechka.ru/upload/iblock/28a/myaso_govyadina.jpg',
            'has_ingredients' => false,
            'provider_id' => 3,
            'parent_id' => null,
            'category_id' => rand(5,7),
            'weight' => rand(115,995)

        ]);
        \App\Models\Product\Product::create([
            'title' => 'market mean123',
            'description' => 'mean bif',
            'type' => 'market',
            'price' => 222,
            'image' => 'http://saechka.ru/upload/iblock/28a/myaso_govyadina.jpg',
            'has_ingredients' => false,
            'provider_id' => 3,
            'parent_id' => null,
            'category_id' => rand(5,8),
            'weight' => rand(115,995)

        ]);
    }
}
