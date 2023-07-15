<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MovieController::class,'index']);

Route::get('/movies',[MovieController::class,'movies']);
Route::get('/tv-shows',[MovieController::class,'tvShows']);
Route::get('/search',[MovieController::class,'search']);
Route::get('/movie/{id}',[MovieController::class,'movieDetails']);
Route::get('/tv/{id}',[MovieController::class,'tvDetails']);