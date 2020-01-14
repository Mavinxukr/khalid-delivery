<?php

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Category::create([
           'type' => 'food'
       ]);
        Category::create([
            'type' => 'service'
        ]);
    }
}
