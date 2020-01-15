<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = [
            'english','japan','arabic',
            'ukrainian','spanish','turkish'
        ];
        foreach ($lang as $lan){
            \App\Models\Provider\Language::create([
                'name' => $lan
            ]);
        }
    }

}
