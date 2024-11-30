<?php
namespace App\Actions;

use Illuminate\Support\Arr;
use App\Models\NewsAggregate;

class CreateNewsAggregateAction
{
    public function handle(array $data, \Closure $next = null)
    {
        $news_aggregate = NewsAggregate::firstOrCreate([
            'source' => $data['source'],
            'category' => $data['category'],
            'title' => $data['title'],
        ], Arr::except($data, ['source', 'category', 'title']));

        $data['news_aggregate'] = $news_aggregate;

        return $next ? $next($data) : true;
    }
}