<?php

// Learning Material

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Pagination\LengthAwarePaginator;

class SimpleFaqController extends Controller
{
    public function index(Request $request)
    {
        // 1. Simple array of 10 items
        $items = [
            'Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5',
            'Item 6', 'Item 7', 'Item 8', 'Item 9', 'Item 10'
        ];

        $perPage = 3; // Show 3 items per page
        $currentPage= $request->query('page', 1); // Get ?page= from URL, default to 1

        // 2. Slice the array to get only the 3 items for the current page
        /*
        $items -> Array of 10 Items
        $perPage -> Number of Items per page -> 3
        $currentPage -> currentPage number -> 1, 2, 3
        $currentPage - 1 -> make it start from 0 (for array indexing) -> 0, 1, 2
        $currentPage - 1 * $perPage -> number of item to start from -> Page 1: 0, Page 2: 3, Page 3: 6 -> Page 2 start from Item 4, Page 3 start from Item 7

        array_slice -> Takes 3 variables -> (<array to slice>, <index of first element from previous array>, <total number of elements in new array>)
         */
        $currentItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        // 3. Create the Paginator object
        $paginator = new LengthAwarePaginator(
            $currentItems,        // The 3 items for this page
            count($items),        // Total items (10)
            $perPage,             // Items per page (3)
            $currentPage,         // Current page number
            ['path' => $request->url()] // Helps Laravel generate page links
        );

        // 4. Send to React as a simple array
        return Inertia::render('simplefaq', [
            'paginatedData' => $paginator->toArray()
        ]);
    }
}
