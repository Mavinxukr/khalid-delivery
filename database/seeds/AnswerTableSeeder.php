<?php

use Illuminate\Database\Seeder;

class AnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $queries = \App\Models\Product\Query::all();

        $data = [
            [
                'title' => 'answer1',
                'price' => '10'
            ],
            [
                'title' => 'answer2',
                'price' => '1000'
            ],
            [
                'title' => 'answer3',
                'price' => '200'
            ],
            [
                'title' => 'answer4',
                'price' => '15'
            ],
            [
                'title' => 'answer5',
                'price' => '100'
            ],
        ];

        foreach ($queries as $query){
            foreach ($data as $item) {
                $query->answers()->create($item);
            }
        }
    }
}
