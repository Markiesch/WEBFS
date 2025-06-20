<?php

use App\Http\Controllers\Restaurant\VisitorsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('restaurant')->name('restaurant.')->group(function () {
    Route::get('/visitors', [VisitorsController::class, 'index'])->name('visitors');
    Route::post('/visitors/save', [VisitorsController::class, 'save'])->name('visitors.save');
});
