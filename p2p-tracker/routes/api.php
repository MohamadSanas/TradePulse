<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiTradeController;

Route::middleware('auth')->group(function () {
    Route::get('/trades', [ApiTradeController::class, 'index']);
    Route::post('/trades', [ApiTradeController::class, 'store']);
    Route::get('/trades/{id}', [ApiTradeController::class, 'show']);
    Route::put('/trades/{id}', [ApiTradeController::class, 'update']);
    Route::delete('/trades/{id}', [ApiTradeController::class, 'destroy']);
});
