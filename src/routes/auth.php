<?php

use App\Http\Controllers\OauthController;
use Illuminate\Support\Facades\Route;

Route::get('/callback', [OauthController::class, 'oauth']);

Route::get('/authorize', [OauthController::class, 'login'])
    ->name('link');
