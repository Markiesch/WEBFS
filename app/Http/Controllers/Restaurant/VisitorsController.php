<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\TableGuest;
use App\Models\TableOccupation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
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

    public function save(FormRequest $request): RedirectResponse
    {
        $request->validate([
            'table' => 'required|exists:tables,id',
            'guests' => 'required|array',
            'guests.*.birthdate' => 'required|date',
            'guests.*.has_deluxe_menu' => 'required|boolean',
        ]);

        $tableId = $request->input('table');

        foreach ($request->input('guests') as $guestData) {
            // Create TableGuest
            $tableGuest = TableGuest::create([
                'birthdate' => $guestData['birthdate'],
                'has_deluxe_menu' => $guestData['has_deluxe_menu'],
            ]);

            // Create TableOccupation
            $tableOccupation = TableOccupation::create([
                'datetime' => now(),
                'table_id' => $tableId,
                'guest_id' => $tableGuest->id,
            ]);

        }

        return redirect()->back()->with('success', 'Guests have been registered successfully.');
    }
}
