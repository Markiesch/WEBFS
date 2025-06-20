<?php

use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\MenuController;
use App\Http\Controllers\Website\NewsController;
use Illuminate\Support\Facades\Route;

Route::name('web.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/menukaart', [MenuController::class, 'index'])->name('menu');

    Route::get('/nieuws', [NewsController::class, 'index'])->name('news');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
});
