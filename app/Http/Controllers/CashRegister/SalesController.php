<?php

namespace App\Http\Controllers\CashRegister;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SalesController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('cash-register/SalesOverview', [
            "records" => OrderItem::with("dish", "sideDish")
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'dish' => $item->dish,
                        'side_dish' => $item->sideDish,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'note' => $item->note,
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'subtotal' => $item->quantity * ($item->price + ($item->sideDish ? $item->sideDish->price : 0)),
                    ];
                }),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'dishes' => 'required|array',
            'dishes.*.dish_id' => 'required|integer|exists:dishes,id',
            'dishes.*.quantity' => 'required|integer|min:1',
            'dishes.*.price' => 'required|numeric|min:0',
            'dishes.*.note' => 'nullable|string|max:255',
            'dishes.*.side_dish_id' => 'nullable|numeric|exists:dishes,id',
        ]);

        $orderData = [
            'user_id' => auth()->id(),
        ];
        $order = auth()->user()->orders()->create($orderData);

        $orderItems = collect($request->input('dishes'))->map(function ($item) {
            return [
                'dish_id' => $item['dish_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'note' => $item['note'] ?? null,
                'side_dish_id' => $item['side_dish_id'] ?? null,
            ];
        })->toArray();
        $order->orderItems()->createMany($orderItems);

        return redirect()->route('dashboard')->with('success', 'Sales data saved successfully.');
    }
}
