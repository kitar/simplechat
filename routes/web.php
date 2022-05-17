<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\RoomsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::guest()) {
        return view('index');
    } else {
        return redirect()->route('dashboard');
    }
})->name('root');

Route::get('rooms', [RoomsController::class, 'index'])->name('rooms.index');
Route::post('rooms', [RoomsController::class, 'store'])->name('rooms.store');
Route::get('rooms/{room}', [RoomsController::class, 'show'])->name('rooms.show');
Route::post('rooms/{room}/enter', [RoomsController::class, 'enter'])->name('rooms.enter');
Route::post('rooms/{room}/leave', [RoomsController::class, 'leave'])->name('rooms.leave');

Route::get('messages/{roomId}/{messageId?}', [MessagesController::class, 'index'])->name('messages.index');
Route::post('messages', [MessagesController::class, 'store'])->name('messages.post');
Route::delete('messages/{roomId}/{messageId}', [MessagesController::class, 'destroy'])->name('messages.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
