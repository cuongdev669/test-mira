<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SerialPasoController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StudentStatController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MemberController;

Route::middleware('basic.auth')->group(function () {
    Route::get('test', [TestController::class, 'test']);

    Route::apiResource('accounts', AccountController::class);
    Route::post('show-serial-paso', [SerialPasoController::class, 'show']);
    Route::get('/students/age-stats', [StudentStatController::class, 'getStats']);
    Route::get('find-member-in-city', [CityController::class, 'find']);
    Route::get('find-member', [MemberController::class, 'find']);
});
