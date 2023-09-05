<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->integer('kotobati_id');
            $table->index('kotobati_id');
            $table->string('kotobati_uuid')->nullable();
            $table->text('url');
            $table->index('url');
            $table->string('title');
            $table->string('author');
            $table->string('pages_count');
            $table->string('language');
            $table->boolean('downloadable');
            $table->string('size_unit')->nullable();
            $table->string('size_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};