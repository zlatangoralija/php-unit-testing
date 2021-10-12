<?php

namespace Tests\Integration;

use App\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    //When we use DatabaseTransactions class, all the data that was created in database in this test, will be rolled back (deleted)
    use DatabaseTransactions;

    public function testFetchesTrendingArticles()
    {
        factory(Article::class, 3)->create();

        factory(Article::class, 2)->create([
            'reads' => 10
        ]);

        $mostPopular = factory(Article::class, 2)->create([
            'reads' => 20
        ]);

        $articles = Article::trending($take = 3);

        $this->assertEquals($mostPopular[0]->id, $articles->first()->id);
        $this->assertCount(3, $articles);
    }

    public function testArticleCanBeCreated()
    {
        $article = factory(Article::class)->create();
        $this->assertCount(1, $article);
    }
}
