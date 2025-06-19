<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Web Routes
Route::name('web.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');

    Route::get('/menukaart', function () {
        return Inertia::render('Menu');
    })->name('menu');

    Route::get('/nieuws', function () {
        return Inertia::render('News');
    })->name('news');

    Route::get('/contact', function () {
        return Inertia::render('Contact');
    })->name('contact');
});

// App Routes
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
