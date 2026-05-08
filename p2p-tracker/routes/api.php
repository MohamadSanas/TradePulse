<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradeController;

Route::middleware('auth')->group(function () {
    Route::get('/trades', [TradeController::class, 'apiIndex']);
    Route::post('/trades', [TradeController::class, 'apiStore']);
    Route::get('/trades/{id}', [TradeController::class, 'apiShow']);
    Route::put('/trades/{id}', [TradeController::class, 'apiUpdate']);
    Route::delete('/trades/{id}', [TradeController::class, 'apiDestroy']);
});
