<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', Controllers\HomeController::class);

Route::get('/projects', [Controllers\ProjectController::class, 'index']);
Route::get('/projects/{slug}', [Controllers\ProjectController::class, 'index']);

Route::get('/blog', [Controllers\BlogController::class, 'index']);
Route::get('/blog/{slug}', [Controllers\BlogController::class, 'index']);
