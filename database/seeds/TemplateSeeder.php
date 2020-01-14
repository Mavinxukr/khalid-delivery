<?php


use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Feedback\FeedbackTemplate::create([
            'body' => 'Perfect',
        ]);
        \App\Models\Feedback\FeedbackTemplate::create([
            'body' => 'Not bad',
        ]);
        \App\Models\Feedback\FeedbackTemplate::create([
            'body' => 'Good',
        ]);
        \App\Models\Feedback\FeedbackTemplate::create([
            'body' => 'Very bad',
        ]);
    }

}
