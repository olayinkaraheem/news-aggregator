<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::group([
    'controller' => NewsController::class,
    'middleware' => [
        'auth:sanctum',
        'email.verified'
    ]
], function () {
    Route::get('/authors', 'listAuthors');
    Route::get('/sources', 'listSources');
    Route::get('/categories', 'listCategories');
    Route::get('/view', 'viewSingleNewsItem');
    Route::get('/preferred', 'listUserPreferedNews');
    Route::get('/', 'listNews');
});
