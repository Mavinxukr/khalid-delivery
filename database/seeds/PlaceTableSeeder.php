<?php

use Illuminate\Database\Seeder;

class PlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\PlaceService\Place::create([
            'user_id' => 7,
            'provider_type'     => 'user',
            'Name' => 'Test',
            'address' => 'Test',
            'city' => 'Tes',
            'postal_code' => '2020',
            'country' => 'Test',
            'latitude' => '20',
            'longitude' => '20',
        ]);
    }
}
