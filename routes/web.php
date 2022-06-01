<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Middleware\CheckGameSession;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('web')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('blackjack.index');
    Route::post('blackjack/start', [GameController::class, 'start'])->name('blackjack.start');

    //Game actions
    Route::middleware([CheckGameSession::class])->group(function () {
        Route::get('blackjack/hit', [GameController::class, 'hit'])->name('blackjack.hit');
        Route::get('blackjack/stay', [GameController::class, 'stay'])->name('blackjack.stay');
        Route::get('blackjack/next', [GameController::class, 'next'])->name('blackjack.next');
    });
});