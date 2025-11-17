<?php

use App\Helpers\Aggregator\NewsApiHelper;
use App\Helpers\Aggregator\NewYorkTimesHelper;
use App\Helpers\Aggregator\TheGuardianHelper;

test('Connection to NewsApi endpoint is successful', function()
{
    $response = (new NewsApiHelper)->getNews('sports');
    $this->assertEquals($response['status'], 'ok');
})->group('aggregators');

test('Connection to New York Times endpoint is successful', function()
{
    $response = (new NewYorkTimesHelper)->getNews('sports');
    $this->assertEquals($response['status'], 'OK');
})->group('aggregators');

test('Connection to The Gaurdian News endpoint is successful', function()
{
    $response = (new TheGuardianHelper)->getNews('world');
    $this->assertEquals($response['status'], 'ok');
})->group('aggregators');