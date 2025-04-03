<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::middleware('basic.auth')->group(function () {
    Route::get('test', [TestController::class, 'test']);
});
