<?php

use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
    Route::get('login/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.callback');
});
