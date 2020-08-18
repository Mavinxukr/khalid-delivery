<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'new', 'placed', 'confirmed', 'on the way', 'delivered', 'canceled'
        ];

        foreach ($statuses as $k => $status){
            \App\Models\Order\OrderStatus::create([
                'name' => $status,
                'step' => $k
            ]);
        }
    }
}
