<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Foundation\Http\FormRequest;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function index(FormRequest $request): Response
    {
        if ($request->has('filter') && $request->has('favorites')) {
            $request->validate([
                'filter' => 'in:all,favorites_asc,favorites_desc,favorites_name_asc,favorites_name_desc',
                'favorites' => 'array',
            ]);

            $filter = $request->input('filter');
            $orderBy = match ($filter ?? 'all') {
                'favorites_desc' => ['menu_number', 'desc'],
                'favorites_name_asc' => ['name', 'asc'],
                'favorites_name_desc' => ['name', 'desc'],
                default => ['menu_number', 'asc'],
            };

            $favoritesNumbers = $request->input('favorites') ?? [];
            $favorites = Dish::whereIn('id', $favoritesNumbers)
                ->orderBy($orderBy)
                ->get();
        }

        $dishGroup = Dish::with('category')->get()->groupBy('category.name');

        if (isset($favorites)) {
            $dishGroup = $dishGroup->prepend('FAVORIETEN', $favorites);
        }

//        dd($dishGroup);

        return Inertia::render('Menu', [
            'dishGroup' => $dishGroup
        ]);
    }

    public function indexFiltered(FormRequest $request): Response
    {
        dd($request->all());
        return $this->index($request);
    }
}
