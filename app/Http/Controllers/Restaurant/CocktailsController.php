<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CocktailsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('restaurant/Cocktails');
    }
}
