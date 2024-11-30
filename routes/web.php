<?php

use App\Helpers\Aggregator\NewsApiHelper;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
