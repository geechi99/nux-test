<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LinkController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [RegistrationController::class, 'show'])->name('home');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');

Route::get('/link/{token}', [LinkController::class, 'show'])->name('link.show');
Route::post('/link/{token}/regen', [LinkController::class, 'regenerate'])->name('link.regen');
Route::post('/link/{token}/deactivate', [LinkController::class, 'deactivate'])->name('link.deactivate');
Route::post('/link/{token}/lucky', [LinkController::class, 'lucky'])->name('link.lucky');
Route::get('/link/{token}/history', [LinkController::class, 'history'])->name('link.history');

