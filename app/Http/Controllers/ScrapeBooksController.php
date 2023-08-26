<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookScraperService;
use Illuminate\Http\Request;

class ScrapeBooksController extends Controller
{

    public function __invoke(Request $request, BookScraperService $scraper)
    {
        $book = new Book();

        try {
            $book = $scraper->scrape(
                request('url'),
                request('pages_count'),
            );
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'resource_type' => 'book',
                'resource' => $book
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'resource scraped successfully',
            'resource_type' => 'book',
            'resource' => $book->formatted()
        ]);
    }
}