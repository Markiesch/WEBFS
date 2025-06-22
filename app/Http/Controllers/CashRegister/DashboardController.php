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
            'dishGroup' => Dish::with('category')->get()->groupBy('category.name'),
            'commonNotes' => OrderItem::whereNotNull('note')
                ->select('note')
                ->groupBy('note')
                ->selectRaw('count(*) as count')
                ->orderByDesc('count')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return $item->note;
//                    return [
//                        'note' => $item->note,
//                        'count' => $item->count,
//                    ];
                }),
        ]);
    }
}
