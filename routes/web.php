<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
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

Route::get('/', [MainController::class, 'index'])->name('index');
Route::any('register', [LoginController::class, 'register'])->name('register');
Route::any('login', [LoginController::class, 'login'])->name('login');
Route::any('logout', [LoginController::class, 'logout'])->name('logout');
Route::any('createSection', [ForumController::class, 'createSection'])->name('createSection')->middleware('auth');
Route::any('createTask', [ForumController::class, 'createTask'])->name('createTask')->middleware('auth');
Route::any('createThread', [ForumController::class, 'createThread'])->name('createThread')->middleware('auth');
