<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradeController;

Route::get('/trades', [TradeController::class, 'index']);
Route::get('/trades/create', [TradeController::class, 'create']);
Route::post('/trades', [TradeController::class, 'store']);
Route::get('/trades/{id}', [TradeController::class, 'show']);
Route::get('/trades/{id}/edit', [TradeController::class, 'edit']);
Route::put('/trades/{id}', [TradeController::class, 'update']);
Route::delete('/trades/{id}', [TradeController::class, 'destroy']);
