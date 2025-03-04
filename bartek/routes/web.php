<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\gameController;

Route::get('/', [gameController::class, 'getData']);

Route::post('/register', [UserController::class, 'register']);
Route::get('/register', function () {return redirect("/");});
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/gameSearch', function () {return view('gameSearching');});
Route::post('/addGame', [gameController::class, 'addGame']);
Route::get('/gamelibrary', [gameController::class, 'getData']);
Route::get('/gamelibrary/{game}', [gameController::class, 'getGameDetail']);
Route::get('/loginOrRegister', function () {return view('login_register');})->name('login');
Route::post('/wishlist', [UserController::class, 'wishlist']);
Route::get('/wishlist', [gameController::class, 'getWishlist'])->middleware('auth');
Route::get('/wishlist/{game}', [gameController::class, 'getWishListDetails'])->middleware('auth');
Route::delete('/delete/{game}', [gameController::class, 'delete']);
Route::delete('/dewishlist/{game}', [UserController::class, 'deleteWishlist']);
