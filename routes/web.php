<?php

use App\Http\Controllers\MessagesController;
use App\Http\Controllers\RoomsController;
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
    return redirect()->route('rooms.index');
});

Route::get('rooms', [RoomsController::class, 'index'])->name('rooms.index');
Route::post('rooms', [RoomsController::class, 'store'])->name('rooms.store');
Route::get('rooms/{room}', [RoomsController::class, 'show'])->name('rooms.show');
Route::get('rooms/{room}/entrance', [RoomsController::class, 'entrance'])->name('rooms.entrance');
Route::post('rooms/{room}/enter', [RoomsController::class, 'enter'])->name('rooms.enter');
Route::post('rooms/{room}/leave', [RoomsController::class, 'leave'])->name('rooms.leave');

Route::get('messages/{roomId}/{messageId?}', [MessagesController::class, 'index'])->name('messages.index');
Route::post('messages', [MessagesController::class, 'store'])->name('messages.post');
