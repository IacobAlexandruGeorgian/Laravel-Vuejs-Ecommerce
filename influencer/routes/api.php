<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ProductController;

Route::get('user', [AuthController::class, 'user']);

Route::get('products', [ProductController::class, 'index']);

Route::group(['middlewre' => 'scope.influencer'], function () {

    Route::post('links', [LinkController::class, 'store']);
    Route::get('stats', [StatsController::class, 'index']);
    Route::get('rankings', [StatsController::class, 'rankings']);
});
