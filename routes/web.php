<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');
Route::any('register', [\App\Http\Controllers\LoginController::class, 'register'])->name('register');
Route::any('login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::any('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::any('createSection', [\App\Http\Controllers\ForumController::class, 'createSection'])->name('createSection');
Route::any('createTask', [\App\Http\Controllers\ForumController::class, 'createTask'])->name('createTask');
