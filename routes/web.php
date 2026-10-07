<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/teams', [TeamController::class, 'index'])
    ->name('teams');

Route::post('/teams', [TeamController::class, 'store'])
    ->name('teams.store');

Route::delete('/teams/{team}', [TeamController::class, 'destroy'])
    ->name('teams.destroy');


// PLAYER ROUTES

Route::get('/players', [PlayerController::class, 'index'])
    ->name('players');

Route::post('/players', [PlayerController::class, 'store'])
    ->name('players.store');

Route::delete('/players/{player}', [PlayerController::class, 'destroy'])
    ->name('players.destroy');


// MATCHES

Route::get('/matches', function () {
    return view('matches');
})->name('matches');