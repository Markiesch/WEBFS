<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TablesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('restaurant/tables/Index');
    }
}
