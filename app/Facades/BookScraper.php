<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class BookScraper extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'BookScraper';
    }
}