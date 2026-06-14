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
    Route::get('/capital-amount', [TradeController::class, 'showCapitalAmount'])
        ->name('capital-amount.index');
    Route::post('/capital-amount', [TradeController::class, 'setCapitalAmount'])
        ->name('capital-amount.set');

    Route::resource('trades', TradeController::class);
    //Route::resource('capital-amount', TradeController::class)->only(['show', 'destroy']);
    Route::post('/capital-amount/withdraw', [TradeController::class, 'withdraw'])
        ->name('capital-amount.withdraw');
    Route::put('/capital-amount/{capitalAmount}', [TradeController::class, 'updateCapitalAmount'])
        ->name('capital-amount.update');
    Route::delete('/capital-amount/{capitalAmount}', [TradeController::class, 'removeCapitalAmount'])
        ->name('capital-amount.destroy');

    Route::get('/capital-amount/{capitalAmount}/edit', [TradeController::class, 'editCapitalAmount'])
    ->name('capital-amount.edit');

    Route::put('/capital-amount/{capitalAmount}', [TradeController::class, 'updateCapitalAmount'])
        ->name('capital-amount.update');

    Route::put('profit/withdraw', [TradeController::class, 'withdrawProfit'])
        ->name('profit.withdraw');

    Route::get('/profit/withdraw', [TradeController::class, 'showWithdrawProfitForm'])
    ->name('profit.withdraw.form');

});

require __DIR__.'/auth.php';
