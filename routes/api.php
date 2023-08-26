<?php

use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/statistics', StatisticsController::class)->name('statistics.index');
    Route::get('/events', EventController::class)->name('events.index');
});
