<?php

namespace App\Services;

use App\Models\Book;
use App\Scrapers\BookScraper;
use Exception;

class BookScraperService
{
    public function scrape($url, $pagesCount = 1)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid url.');
        }

        $url = parse_url($url);

        $provider = $this->detectProvider($url);

        return (new $provider($url, $pagesCount))->scrape($url);
    }

    private function detectProvider($url)
    {

        $provider = $url['host'];

        if (!array_key_exists($provider, BookScraper::PROVIDERS)) {
            throw new Exception(
                'This book provider isn\'t supported yet. '
                . 'please use one of these providers: '
                . implode(', ', array_keys(BookScraper::PROVIDERS))
            );
        }

        return BookScraper::PROVIDERS[$provider];
    }
}