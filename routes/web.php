<?php

use App\Http\Controllers\ScrapeBooksController;
use App\Services\BookScraperService;
use Goutte\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'scraper');
Route::get('/scrape', ScrapeBooksController::class);