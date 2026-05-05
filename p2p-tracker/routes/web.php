<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradeController;

Route::resource('trades', TradeController::class);

Route::get('/', function () {
    return redirect('/trades');
});