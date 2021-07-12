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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('blogs', [App\Http\Controllers\BlogController::class, 'store'])->name('blog.store');
Route::get('blogs/{blog}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::patch('blogs/{blog}/update', [App\Http\Controllers\BlogController::class, 'update'])->name('blog.update');
Route::delete('blogs/{blog}/delete', [App\Http\Controllers\BlogController::class, 'destroy'])->name('blog.delete');
Route::post('blogs/{blog}/like', [App\Http\Controllers\LikeController::class, 'toggle'])->name('blog.like');
