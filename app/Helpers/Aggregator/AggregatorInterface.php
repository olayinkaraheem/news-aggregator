<?php
namespace App\Helpers\Aggregator;

interface AggregatorInterface
{
    public function getNews(string $query, int $page = 1): array;
    public function getSources(): array;
}