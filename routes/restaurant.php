<?php

use App\Http\Controllers\Restaurant\CocktailsController;
use App\Http\Controllers\Restaurant\VisitorsController;
use Illuminate\Support\Facades\Route;

Route::get('/tablet/cocktails', [CocktailsController::class, 'index'])->name('tablet.cocktails');
