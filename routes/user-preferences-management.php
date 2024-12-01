<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPreferenceController;

Route::group([
    'controller' => UserPreferenceController::class,
    'middleware' => [
        'auth:sanctum',
        'email.verified'
    ]
], function () {
    Route::post('/', 'setPreferences');
    Route::get('/', 'getPreferences');
});