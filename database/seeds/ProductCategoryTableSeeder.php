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
            'type'  => 'japan kitchen',
            'image' => 'https://images.unsplash.com/photo-1523895665936-7bfe172b757d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'
        ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'italy kitchen',
            'image' => 'https://images.unsplash.com/photo-1523895665936-7bfe172b757d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'
        ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'ukrainian kitchen',
            'image' => 'https://images.unsplash.com/photo-1523895665936-7bfe172b757d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'
        ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'winter menu',
            'image' => 'https://images.unsplash.com/photo-1523895665936-7bfe172b757d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'
        ]); \App\Models\Category\ProductCategory::create([
            'type' => 'vegetables'
    ]); \App\Models\Category\ProductCategory::create([
            'type' => 'fruit',
        'image' => 'https://images.unsplash.com/photo-1523895665936-7bfe172b757d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'
    ]);
        \App\Models\Category\ProductCategory::create([
            'type' => 'fish',
            'image' => 'https://images.unsplash.com/photo-1523895665936-7bfe172b757d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'
        ]);

        \App\Models\Category\ProductCategory::create([
            'type' => 'vegetables',
            'image' => 'https://images.unsplash.com/photo-1523895665936-7bfe172b757d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'
        ]);
    }
}
