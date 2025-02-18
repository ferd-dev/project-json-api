<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    public function index(): ArticleCollection
    {
        return ArticleCollection::make(Article::all());
    }

    public function create(): ArticleResource
    {
        $article = Article::create([
            'title' => request('data.attributes.title'),
            'slug' => request('data.attributes.slug'),
            'content' => request('data.attributes.content'),
        ]);

        return ArticleResource::make($article);
    }
}
