<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CityController;

Route::middleware('basic.auth')->group(function () {
    Route::get('test', [TestController::class, 'test']);

    Route::apiResource('accounts', AccountController::class);
    Route::get('find-member-in-city', [CityController::class, 'find']);
});
