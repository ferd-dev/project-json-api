<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_articles(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'My First Article',
                    'slug' => 'my-first-article',
                    'content' => 'Content of my first article',
                ],
            ],
        ]);

        $response->assertCreated();

        $article = Article::first();

        $response->assertHeader(
            'Location',
            route('api.v1.articles.show', $article)
        );

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => 'My First Article',
                    'slug' => 'my-first-article',
                    'content' => 'Content of my first article',
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article),
                ],
            ]
        ]);
    }

    /** @test */
    public function title_is_required(): void
    {
        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'slug' => 'my-first-article',
                    'content' => 'Content of my first article',
                ],
            ],
        ]);

        $response->assertJsonValidationErrors('data.attributes.title');
    }

    /** @test */
    public function slug_is_required(): void
    {
        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'My First Article',
                    'content' => 'Content of my first article',
                ],
            ],
        ]);

        $response->assertJsonValidationErrors('data.attributes.slug');
    }

    /** @test */
    public function content_is_required(): void
    {
        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'My First Article',
                    'slug' => 'my-first-article',
                ],
            ],
        ]);

        $response->assertJsonValidationErrors('data.attributes.content');
    }

    /** @test */
    public function title_must_be_at_least_4_characters(): void
    {
        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'My',
                    'slug' => 'my-first-article',
                    'content' => 'Content of my first article',
                ],
            ],
        ]);

        $response->assertJsonValidationErrors('data.attributes.title');
    }
}
