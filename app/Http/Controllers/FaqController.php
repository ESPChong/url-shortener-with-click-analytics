<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\FaqRepositoryInterface;

class FaqController extends Controller {
    public function __construct(
        private FaqRepositoryInterface $faqRepository
    ) {}

    public function index(Request $request)
    {
        return Inertia::render('faq', [
            'faqs' => $this->faqRepository->getPaginated(5)
        ]);
    }
}
