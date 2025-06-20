<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Inertia\Inertia;
use Inertia\Response;

class VisitorsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('restaurant/visitors/Index', [
            'tables' => Table::all()
        ]);
    }
}
