<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FaqController extends Controller {
    public function index(Request $request) {
        // Array of faqs
        $faqs = collect([
            ['id' => 1, 'question' => 'What is an FAQ?', 'answer' => 'FAQ stands for "Frequently Asked Questions"'],
            ['id' => 2, 'question' => 'Why does this page exist?', 'answer' => 'It exists for me to try more stuff with Tailwind CSS.'],
            ['id' => 3, 'question' => 'What is this web app?', 'answer' => 'A URL Shortener with a Click Analytics Dashboard.'],
            ['id' => 4, 'question' => 'Why was this web app developed?', 'answer' => 'To be a Laravel, React, Inertia and Tailwind CSS learning project.'],
            ['id' => 5, 'question' => 'What is the tech stack for this project?', 'answer' => 'Laravel, React, Inertia, Tailwind CSS, MySQL, Redis and Docker.'],
            ['id' => 6, 'question' => 'How many endpoints does this web app have?', 'answer' => '3.'],
            ['id' => 7, 'question' => 'What are the endpoints?', 'answer' => '/shorten, /redirect and /dashboard.'],
            ['id' => 8, 'question' => 'Who is the developer?', 'answer' => 'My name is Corrin.'],
            ['id' => 9, 'question' => 'Does he have a GitHub repo?', 'answer' => 'Yes, here is the link: (https://github.com/ESPChong/url-shortener-with-click-analytics).'],
            ['id' => 10, 'question' => 'Is this project using SQL or NoSQL?', 'answer' => 'It is using SQL.'],
            ['id' => 11, 'question' => 'Which SQL is being used for this project', 'answer' => 'MySQL.'],
            ['id' => 12, 'question' => 'Why is SQL chosen for this webapp?', 'answer' => 'For its ACID properties and Analytics Capabilities.'],
            ['id' => 13, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 14, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 15, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 16, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 17, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 18, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 19, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 20, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 21, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 22, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 23, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 24, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 25, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 26, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 27, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 28, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 29, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],
            ['id' => 30, 'question' => 'Placeholder?', 'answer' => 'Placeholder answer.'],

        ]);

        $perPage = 5;
        $currentPage = $request->query('page', 1);  // Get ?page from URL, default to 1

        $currentItems = $faqs->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $currentItems,
            $faqs->count(),
            $perPage,
            $currentPage
            );

        return Inertia::render('faq',[
            'faqs' => $paginator->jsonSerialize()
            ]);
    }
}
