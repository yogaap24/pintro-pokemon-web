<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/', [PokemonController::class, 'index'])->name('home');
Route::get('/pokemon/{id?}', [PokemonController::class, 'getPokemon']);
Route::get('/pokemon/{name?}', [PokemonController::class, 'getPokemon']);
