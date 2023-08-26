<?php

namespace App\Models;

use App\Scrapers\KotobatiScraper;
use App\Services\BookScraperService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'downloadable' => 'boolean'
    ];

    protected function size(): Attribute
    {
        return Attribute::make(
        get: fn() => $this->downloadable ? "$this->size_value $this->size_unit" : 'N/A'
        );
    }

    protected function downloadUrl(): Attribute
    {
        return Attribute::make(
        get: fn() => $this->downloadable ? KotobatiScraper::BASE_URL . "/book/download/{$this->kotobati_uuid}" : 'N/A'
        );
    }


    public function formatted()
    {
        return $this->only([
            'title',
            'author',
            'downloadable',
            'language',
            'pages_count',
        ]) + ['size' => $this->size, 'downloadUrl' => $this->downloadUrl];
    }
}