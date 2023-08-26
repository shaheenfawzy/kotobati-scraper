<?php

namespace App\Scrapers;

use App\Models\Book;
use Exception;
use Illuminate\Support\Benchmark;

class KotobatiScraper extends BookScraper
{
    const BASE_URL = 'https://www.kotobati.com';

    public function __construct(
        public $url = [],
        public $pagesCount = 1,
        public $totalTimeTaken = [],
    ) {
        parent::__construct();

        $this->validatePath();
    }

    public function scrape()
    {
        return $this->scrapeTarget();
    }

    protected function scrapePages($path)
    {
        $currentPage = 1;
        $books = [];

        while ($currentPage <= $this->pagesCount) {
            $crawler = $this->client->request('GET', self::BASE_URL . $path . "?page=$currentPage");

            if ($crawler->filter('.book-teaser')->count() === 0) {
                break;
            }

            $pageNumber = sprintf('%02d', $currentPage);
            $timeTakenMs = Benchmark::value(function () use ($crawler, &$books, $pageNumber) {
                $this->scrapePage($crawler, $books, $pageNumber);
            });

            $timeTaken = round($timeTakenMs[1] / 1000, 2);

            $this->totalTimeTaken[] = $timeTaken;

            app()->runningInConsole() && $this->cmd->writeln(
                "\n<info>Finished page: <fg=yellow>{$pageNumber}</> "
                . "took: <fg=yellow>{$timeTaken}</> seconds\n"
            );

            $currentPage++;
        }

        $this->totalTimeTaken = array_reduce($this->totalTimeTaken, fn($p, $n) => $p + $n);

        app()->runningInConsole() && $this->cmd->writeln(
            "<info>Finished all pages: <fg=yellow>{$this->pagesCount}</> "
            . "Total time: <fg=yellow>{$this->totalTimeTaken} </>seconds"
        );

        return $books;
    }

    protected function scrapePage($crawler, $book, $pageNumber)
    {
        $crawler->filter('.book-teaser')->each(function ($node, $index) use (&$books, $pageNumber) {
            $path = $node->filter('.title > a')->attr('href');
            $id = $node->filter('.btn-fav.add-to-fav');
            $idExists = $id->count() > 0;
            $id = $idExists ? $id->attr('data-id') : null;
            $bookNumber = sprintf('%02d', $index + 1);

            try {
                $books[] = $this->scrapeBook($path, $id, $bookNumber, $pageNumber);
            } catch (\Throwable $e) {
                app()->runningInConsole() && $this->cmd->writeln(
                    "<fg=black bg=red>{$e->getMessage()}</> "
                );
                report($e);
            }

        });
    }

    protected function scrapeBook($path, $id = null, $bookNumber = 1, $pageNumber = 1)
    {
        $url = self::BASE_URL . $path;
        $book = Book::whereKotobatiId($id)->orWhere('url', $url)->first();

        if (!is_null($book)) {
            app()->runningInConsole() && $this->cmd->writeln(
                "<info>Found    book: <fg=yellow>{$bookNumber}</> "
                . "page: <fg=yellow>{$pageNumber}</> "
                . "id: <fg=yellow>{$book->kotobati_id}</>"
            );

            return $book;
        }

        app()->runningInConsole() && $this->cmd->writeln(
            "<info>Scraping  url: <fg=yellow>{$url}</> "
        );

        $crawler = $this->client->request('GET', $url);
        $parent = $crawler->filter('.media > .media-body');

        if ($parent->count() === 0) {
            throw new Exception('Invalid book url');
        }
        $info = $parent->filter('.book-table-info > li');
        $downloadable = $crawler->filter('.download')->count() > 0;

        $book = [
            'kotobati_id' => $crawler->filter('article')->attr('data-history-node-id'),
            'kotobati_uuid' => $downloadable ? explode('/', $crawler->filter('.read')->attr('href'))[3] : null,
            'url' => $url,
            'title' => $parent->filter('.img-title')->text(),
            'author' => $parent->filter('.book-p-info > a')->text(),
            'pages_count' => $info->eq(0)->filter('p')->eq(1)->filter('span')->text(),
            'language' => $info->eq(1)->filter('p')->eq(1)->text(),
            'downloadable' => $downloadable,
            'size_unit' => $downloadable ? $info->eq(2)->filter('p')->eq(1)->innerText() : null,
            'size_value' => $downloadable ? $info->eq(2)->filter('p')->eq(1)->filter('.numero')->text() : null,
        ];

        app()->runningInConsole() && $this->cmd->writeln(
            "<info>Scraped  book: <fg=yellow>{$bookNumber}</> "
            . "page: <fg=yellow>{$pageNumber}</> "
            . "id: <fg=yellow>{$book['kotobati_id']}</>\n"
        );

        return Book::create($book);
    }

    protected function validatePath()
    {
        if (
            !str_starts_with($this->url['path'], '/section/') &&
            !str_starts_with($this->url['path'], '/book')
        ) {
            throw new Exception('This page isn\'t supported yet.');
        }
    }

    protected function scrapeTarget()
    {
        $path = $this->url['path'];

        return str_starts_with($path, '/section/')
            ? $this->scrapePages($path)
            : $this->scrapeBook($path);
    }
}