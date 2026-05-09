<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradeController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [TradeController::class, 'viewUpdateAverageBuyPrice'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/trades/update-average-buy-price', [TradeController::class, 'updateAverageBuyPrice'])
        ->name('trades.updateAverageBuyPrice');

    Route::resource('trades', TradeController::class);
});

require __DIR__.'/auth.php';
