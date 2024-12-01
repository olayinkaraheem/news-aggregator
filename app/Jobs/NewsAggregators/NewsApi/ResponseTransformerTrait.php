<?php
namespace App\Jobs\NewsAggregators\NewsApi;

trait ResponseTransformerTrait
{
    
    protected function transformResponseFormat(array $articles): array
    {
        return collect($articles)->map(function ($article) {
            return [
                'title' => $article['title'],
                'content' => $article['content'],
                'url' => $article['url'],
                'source' => $article['source']['name'],
                'published_date' => $article['publishedAt'],
                'image_url' => $article['urlToImage'],
                'author' => $article['author'] ?? $article['source']['name'],
                'category' => $this->category,
                'description' => $article['description'] ?? null,
            ];
        })->toArray();
    } 
}