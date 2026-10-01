<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/teams', function () {
    return view('teams');
})->name('teams');

Route::get('/players', function () {
    return view('players');
})->name('players');

Route::get('/matches', function () {
    return view('matches');
})->name('matches');