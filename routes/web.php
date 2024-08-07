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

Route::prefix('pokemon')->controller(PokemonController::class)->group(function () {
    Route::get('/{id?}', 'getPokemonById')->name('showbyid');
    Route::get('/{name?}', 'getPokemonByName')->name('showbyname');
});