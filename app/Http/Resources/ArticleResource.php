<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'articles',
            'id' => (string) $this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->resource->title,
                'slug' => $this->resource->slug,
                'content' => $this->resource->content,
            ],
            'links' => [
                'self' => route('api.v1.articles.show', $this->resource),
            ],
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->withHeaders([
            'Location' => route('api.v1.articles.show', $this->resource),
        ]);
    }
}
