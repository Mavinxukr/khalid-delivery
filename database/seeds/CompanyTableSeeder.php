<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Provider\Provider::create([
            'phone_number' => '+390-33-33-44-421',
            'name' => 'senator',
            'website' => 'www.xxx',
            'description' => 'food restaurant',
            'chamber_of_commerce' => '11222334445',
            'image'=>'https://media-cdn.tripadvisor.com/media/photo-s/0e/cc/0a/dc/restaurant-chocolat.jpg',
            'category_id' => 1
        ]);

        \App\Models\Provider\Provider::create([
            'phone_number' => '+390-33-00-00-000',
            'name' => 'clean',
            'website' => 'www.clean',
            'description' => 'cleaning company',
            'chamber_of_commerce' => '00000000000',
            'image'=>'https://www.stathakis.com/hs-fs/hubfs/6-1.jpg?width=1600&name=6-1.jpg',
            'category_id' => 2
        ]);

        \App\Models\Provider\Provider::create([
            'phone_number' => '+390-55-55-55-555',
            'name' => 'market',
            'website' => 'www.clean',
            'description' => 'market',
            'chamber_of_commerce' => '3434343434',
            'image'=>'https://media-cdn.tripadvisor.com/media/photo-s/18/2b/25/bc/traditional-market.jpg',
            'category_id' => 3
        ]);
    }
}
