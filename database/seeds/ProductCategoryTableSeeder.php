<?php

use Illuminate\Database\Seeder;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category\ProductCategory::create([
            'type' => 'japan kitchen'
        ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'italy kitchen'
        ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'ukrainian kitchen'
        ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'winter menu'
        ]); \App\Models\Category\ProductCategory::create([
        'type' => 'vegetables'
    ]); \App\Models\Category\ProductCategory::create([
        'type' => 'fruit'
    ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'fish'
        ]);
    }
}
