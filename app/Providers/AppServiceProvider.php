<?php

namespace App\Providers;

use App\Scrapers\BookScraper;
use App\Scrapers\KotobatiScraper;
use App\Services\BookScraperService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->singleton('BookScraper', function () {
            return new BookScraperService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 
    }
}