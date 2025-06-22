<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    // List all dishes with pagination
    public function index(Request $request): Response
    {
        $dishes = Dish::with('category')->paginate(15);
        $categories = Category::all();

        return Inertia::render('admin/DishOverview', [
            'dishes' => $dishes->items(),
            'pagination' => [
                'current_page' => $dishes->currentPage(),
                'last_page' => $dishes->lastPage(),
                'per_page' => $dishes->perPage(),
                'total' => $dishes->total(),
                'from' => $dishes->firstItem(),
                'to' => $dishes->lastItem(),
                'links' => $dishes->linkCollection(),
            ],
            'categories' => $categories,
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
        try {
            $dish = Dish::create($validated);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Integrity constraint violation
                return back()->withErrors(['menu_number' => 'Dit menunummer bestaat al.'])->withInput();
            }
            throw $e;
        }
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
        try {
            $dish->update($validated);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Integrity constraint violation
                return back()->withErrors(['menu_number' => 'Dit menunummer bestaat al.'])->withInput();
            }
            throw $e;
        }
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
