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

Route::get('rooms/{roomId}', [RoomsController::class, 'show']);
Route::get('messages/{roomId}/{messageId?}', [MessagesController::class, 'index']);
Route::post('messages', [MessagesController::class, 'store']);
