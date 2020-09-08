<?php

use Illuminate\Database\Seeder;

class CompanySettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Provider\SettingProvider::create([
            'provider_id' => 1,
            'kitchen'       => 'italy,japan,spanish',
            'time_delivery_mean' => '60 min',
            'min_order'     => 100,
            'delivery_fee'  => '10$',
            'tags'  => 'good,dish,tasty,not_bad',
            'rating' => 5,
            'price_rating' => 4


        ]);
    }
}
