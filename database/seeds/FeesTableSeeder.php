<?php

use Illuminate\Database\Seeder;

class FeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Fee\Fee::create([
            'name'  => 'service_vat',
            'type'  => 'percents',
            'count' => '5',
        ]);
        \App\Models\Fee\Fee::create([
            'name'  => 'service_charge',
            'type'  => 'cash',
            'count' => '5',
        ]);
        \App\Models\Fee\Fee::create([
            'name'  => 'service_received',
            'type'  => 'percents',
            'count' => '80',
        ]);
        \App\Models\Fee\Fee::create([
            'name'  => 'food_vat',
            'type'  => 'percents',
            'count' => '5',
        ]);
        \App\Models\Fee\Fee::create([
            'name'  => 'food_markup',
            'type'  => 'percents',
            'count' => '4',
        ]);
        \App\Models\Fee\Fee::create([
            'name'  => 'food_charge',
            'type'  => 'cash',
            'count' => '5',
        ]);
        \App\Models\Fee\Fee::create([
            'name'  => 'food_received',
            'type'  => 'percents',
            'count' => '95',
        ]);
    }
}
