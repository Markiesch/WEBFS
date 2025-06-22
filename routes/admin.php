<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\CashRegister\DashboardController;
use App\Http\Controllers\CashRegister\SalesController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix("kassa")->group(function () {
        Route::get("dashboard", [DashboardController::class, 'show'])->name('dashboard');
        Route::get("orders", [SalesController::class, 'show'])->name('orders');
    });

    Route::prefix("admin")->name('admin.')->group(function () {
        Route::get("dashboard", [DashboardController::class, 'show'])->name('dashboard');
        Route::get("orders", [SalesController::class, 'show'])->name('orders');
        Route::post('order', [SalesController::class, 'store'])->name('order.create');

        Route::get('menu', [MenuController::class, 'edit'])->name('menu.edit');
//        Route::get('menu/:id', [MenuController::class, 'edit'])->name('menu.edit');
        Route::patch('menu/:id', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('menu/:id', [MenuController::class, 'destroy'])->name('menu.destroy');
    });

    Route::prefix('restaurant')->name('restaurant.')->group(function () {
        Route::get('/visitors', [VisitorsController::class, 'index'])->name('visitors');
        Route::post('/visitors/save', [VisitorsController::class, 'save'])->name('visitors.save');
    });
});

