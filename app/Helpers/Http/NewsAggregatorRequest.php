<?php

namespace App\Helpers\Http;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NewsAggregatorRequest
{
    public static function get( string $url, array $headers = [], ?string $provider = null, ?array $mockResponse = [] ): array
    {
        if (!empty($mockResponse)) {
            return $mockResponse;
        }
        
        $start = time();

        $response = Http::withHeaders( $headers )->get( $url );

        $data = $response->json();

        $end = time();

        Log::debug([$url, $end - $start, $provider, $response]);

        return [
            'status'    => $response->status(),
            'data'      => $data
        ];
    }

    public static function post( string $url, array $request, array $headers = [], ?string $provider = null, ?array $mockResponse = [] ) : array
    {
        if (!empty($mockResponse)) {
            return $mockResponse;
        }
        
        $start = time();

        $response = Http::withHeaders( $headers )->post( $url, $request );

        $data = $response->json();

        $end = time();

        Log::debug([$url, $request, $end - $start, $provider, $response]);

        return [
            'status'    => $response->status(),
            'data'      => $data
        ];
    }
}
