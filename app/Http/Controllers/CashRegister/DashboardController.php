<?php

namespace App\Http\Controllers\CashRegister;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('cash-register/Dashboard', [
            'dishGroup' => Dish::with('category')->get()->groupBy('category.name'),
        ]);
    }
}
