<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    // List all dishes
    public function index(Request $request): Response
    {
        $dishes = Dish::with('category')->get();
        return Inertia::render('admin/DishOverview', [
            'dishes' => $dishes,
        ]);
    }

    // Show a single dish
    public function show($id): Response
    {
        $dish = Dish::with('category')->findOrFail($id);
        return Inertia::render('admin/DishDetail', [
            'dish' => $dish,
        ]);
    }

    // Create a new dish
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'menu_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'is_side_dish' => 'boolean',
        ]);
        $dish = Dish::create($validated);
        return redirect()->route('admin.dishes.index')->with('success', 'Dish created.');
    }

    // Update an existing dish
    public function update(Request $request, $id)
    {
        $dish = Dish::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'menu_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'is_side_dish' => 'boolean',
        ]);
        $dish->update($validated);
        return redirect()->route('admin.dishes.index')->with('success', 'Dish updated.');
    }

    // Delete a dish
    public function destroy($id)
    {
        $dish = Dish::findOrFail($id);
        $dish->delete();
        return redirect()->route('admin.dishes.index')->with('success', 'Dish deleted.');
    }
}
