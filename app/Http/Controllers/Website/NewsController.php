<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('News', [
            'newsPosts' => NewsPost::all()->sortByDesc('created_at'),
        ]);
    }
}
