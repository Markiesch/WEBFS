<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Web Routes
require __DIR__ . '/website.php';


// App Routes
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
