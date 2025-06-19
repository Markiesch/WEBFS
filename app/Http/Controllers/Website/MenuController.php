<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Menu', [
            'dishGroup' => Dish::with('category')->get()->groupBy('category.name'),
        ]);
    }
}
