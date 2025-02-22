<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/cars', [CarController::class, 'store']);
Route::post('/parts', [PartController::class, 'store']);

Route::get('/cars', [CarController::class, 'index']);
Route::get('/parts', [PartController::class, 'index']);

Route::get('/cars/search', [CarController::class, 'search']);
Route::get('/parts/search', [PartController::class, 'search']);

Route::delete('/cars/{id}', [CarController::class, 'destroy']);
Route::delete('/parts/{id}', [PartController::class, 'destroy']);

Route::put('/cars/{id}', [CarController::class, 'update']);
Route::put('/parts/{id}', [PartController::class, 'update']);

Route::get('/cars/show/{id}', [CarController::class, 'show']);
Route::get('/parts/show/{id}', [PartController::class, 'show']);

Route::get('/cars/group/{id}', [CarController::class, 'group']);
Route::get('/parts/group/{id}', [PartController::class, 'group']);
