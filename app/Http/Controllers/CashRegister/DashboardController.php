<?php

namespace App\Http\Controllers\CashRegister;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\OrderItem;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('cash-register/Dashboard', [
            'dishGroup' => Dish::where('is_side_dish', False)->with('category')->get()->groupBy('category.name'),
            'sideDishes' => Dish::where('is_side_dish', True)->get(),
            'commonNotes' => OrderItem::whereNotNull('note')
                ->select('note')
                ->groupBy('note')
                ->selectRaw('count(*) as count')
                ->orderByDesc('count')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return $item->note;
                }),
        ]);
    }
}
