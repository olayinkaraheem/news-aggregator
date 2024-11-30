<?php
namespace App\Jobs\NewsAggregators\NewsApi;

trait ResponseTransformerTrait
{
    protected function transformResponse(array $response_data)
    {
        return [
            // transform keys here to meet requirements for CreateNewsAggregateAction
        ];
    }
    // This trait can't be shared
    // cos for source call, 
}