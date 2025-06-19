<?php

namespace App\Http\Controllers\CashRegister;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Dish;

class DashboardController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('cash-register/Dashboard', [
            'dishGroup' => Dish::with('category')->get()->groupBy('category.name'),
        ]);
    }
}
