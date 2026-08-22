<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller {
    public function index(Request $request) {
        // Array of faqs
        $faqs = DB::table('faqs')->get();

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
