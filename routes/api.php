<?php

use App\Http\Controllers\Api\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('api.v1.articles.show');
