<?php

namespace App\Scrapers;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

abstract class BookScraper
{
    const PROVIDERS = [
        'www.kotobati.com' => KotobatiScraper::class
    ];

    public function __construct(
        public $client = new HttpBrowser(), public $cmd = new \Symfony\Component\Console\Output\ConsoleOutput())
    {
        // I was forced to change the user agent because the website's authors blocked me with cloudflare :)
        $this->client->setServerParameter(
            'HTTP_USER_AGENT',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36'
        );
    }

    abstract public function scrape();
    abstract protected function scrapePages($path);
    abstract protected function scrapeBook($path);
}