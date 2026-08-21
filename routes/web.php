<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('tentang', 'tentang')->name('tentang');

Route::get('layanan', [PortfolioController::class, 'services'])->name('layanan');
Route::redirect('benefit', 'layanan')->name('benefit');

Route::get('proyek', [PortfolioController::class, 'projects'])->name('proyek');
Route::get('proyek/{slug}', [PortfolioController::class, 'projectShow'])->name('proyek.show');

Route::get('blog', [PortfolioController::class, 'blog'])->name('blog');
Route::get('blog/{slug}', [PortfolioController::class, 'blogShow'])->name('blog.show');

Route::get('kontak', [PortfolioController::class, 'contact'])->name('kontak');
Route::post('messages/store', [MessageController::class, 'store'])->name('messages.store');