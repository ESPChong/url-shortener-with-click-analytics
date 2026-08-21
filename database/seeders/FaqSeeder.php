<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Faq::create(['one','two']);
        DB::transaction(function () {
            $definedFaqs = [
                ['question' => 'What is an FAQ?', 'answer' => 'FAQ stands for "Frequently Asked Questions"'],
                ['question' => 'Why does this page exist?', 'answer' => 'It exists for me to try more stuff with Tailwind CSS.'],
                ['question' => 'What is this web app?', 'answer' => 'A URL Shortener with a Click Analytics Dashboard.'],
                ['question' => 'Why was this web app developed?', 'answer' => 'To be a Laravel, React, Inertia and Tailwind CSS learning project.'],
                ['question' => 'What is the tech stack for this project?', 'answer' => 'Laravel, React, Inertia, Tailwind CSS, MySQL, Redis and Docker.'],
                ['question' => 'How many endpoints does this web app have?', 'answer' => '3.'],
                ['question' => 'What are the endpoints?', 'answer' => '/shorten, /redirect and /dashboard.'],
                ['question' => 'Who is the developer?', 'answer' => 'My name is Corrin.'],
                ['question' => 'Is there a GitHub repo?', 'answer' => 'Yes, here is the link: (https://github.com/ESPChong/url-shortener-with-click-analytics).'],
                ['question' => 'Is this project using SQL or NoSQL?', 'answer' => 'It is using SQL.'],
                ['question' => 'Which SQL is being used for this project', 'answer' => 'MySQL.'],
                ['question' => 'Why is SQL chosen for this webapp?', 'answer' => 'For its ACID properties and Analytics Capabilities.'],
            ];

            foreach ($definedFaqs as $faq){
                Faq::create($faq);
            }

            // Here there is an option to use the below code to generate the rest of the faqs,
            // OR a factory could be used instead

            // for ($i = count($definedFaqs); $i < 30; $i++){
            //     Faq::create([]);  // use default values defined in Faq Model
            // }

            // Factory
            $faqCount = count($definedFaqs);
            Faq::factory()->count($faqCount)->placeholder()->create();
        });
    }
}
