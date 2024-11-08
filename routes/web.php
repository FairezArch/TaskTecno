<?php

use App\Http\Controllers\LearningActivityController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\TaskController;
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

Route::resource('/', LearningActivityController::class)->only('index');
Route::resource('/method', MethodController::class);
Route::resource('/task', TaskController::class);
