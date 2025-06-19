<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        return Inertia::render('Menu');
    }
}
