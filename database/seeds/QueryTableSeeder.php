<?php

use Illuminate\Database\Seeder;

class QueryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = \App\Models\Product\Product::whereType('service')->first();

        $data = [
            ['title' => 'Query1'],
            ['title' => 'Query2'],
            ['title' => 'Query3'],
            ['title' => 'Query4'],
            ['title' => 'Query5'],
            ['title' => 'Query6'],
        ];

        foreach ($data as $item){
            $product->queries()->create($item);
        }
    }
}
