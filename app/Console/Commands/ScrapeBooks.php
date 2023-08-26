<?php

namespace App\Console\Commands;

use App\Facades\BookScraper;
use Illuminate\Console\Command;

class ScrapeBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:books {url} {--P|pages=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scrape books/book from given url.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            BookScraper::scrape(
                $this->argument('url'),
                $this->option('pages')
            );
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            report($e);
        }

        return 0;
    }
}