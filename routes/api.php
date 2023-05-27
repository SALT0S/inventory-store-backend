<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\LogoutController;
use \App\Http\Controllers\UserController;

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
// Auth ...
Route::post('/login', LoginController::class);
// Route::post('/register', RegisterController::class);
Route::post('/logout', LogoutController::class);

// User ...
Route::get('/user', UserController::class)->middleware(['auth:sanctum']);

// Rutas para la tabla de productos
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store'])->middleware(['auth:sanctum', 'verified']);
Route::put('products/{id}', [ProductController::class, 'update'])->middleware(['auth:sanctum', 'verified']);
Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware(['auth:sanctum', 'verified']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);



// Additional routes for user profile, password reset, etc.
