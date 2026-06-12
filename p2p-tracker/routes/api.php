<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiTradeController;

Route::middleware('auth')->group(function () {
    Route::get('/trades', [ApiTradeController::class, 'index']);
    Route::post('/trades', [ApiTradeController::class, 'store']);
    Route::get('/trades/{id}', [ApiTradeController::class, 'show']);
    Route::put('/trades/{id}', [ApiTradeController::class, 'update']);
    Route::delete('/trades/{id}', [ApiTradeController::class, 'destroy']);
    Route::post('/trades/{id}/apply-status', [ApiTradeController::class, 'apiApplyTradeToCurrentStatus']);
    Route::post('/trades/{id}/add-profit', [ApiTradeController::class, 'apiAddProfiteToCurrentProfite']);

    Route::get('/current-status', [ApiTradeController::class, 'apiViewUpdateAverageBuyPrice']);
    Route::post('/current-status', [ApiTradeController::class, 'apiUpdateAverageBuyPrice']);
    Route::delete('/current-status/{id}', [ApiTradeController::class, 'apiDestroyEffectiveBuyPrice']);
    Route::post('/break-even-price', [ApiTradeController::class, 'apiCalculateBreakEvenPrice']);

    Route::get('/capital-amount', [ApiTradeController::class, 'apiShowCapitalAmount']);
    Route::post('/capital-amount', [ApiTradeController::class, 'apiSetCapitalAmount']);
});
