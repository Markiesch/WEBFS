<?php

use App\Http\Controllers\CashRegister\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->prefix("kassa")->group(function () {
    Route::get("dashboard", [DashboardController::class, 'show'])->name('dashboard');
});
