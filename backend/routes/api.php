<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AccountController;

Route::middleware('basic.auth')->group(function () {
    Route::get('test', [TestController::class, 'test']);

    Route::apiResource('accounts', AccountController::class);
});
