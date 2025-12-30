<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalReservation;
use Illuminate\Http\Request;

class RentalReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = RentalReservation::with(['rentalItem', 'order', 'orderItem']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rental item if provided
        if ($request->filled('rental_item_id')) {
            $query->where('rental_item_id', $request->rental_item_id);
        }

        // Filter by date range if provided
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }

        $reservations = $query->latest()->paginate(15);

        return view('admin.rental-reservations.index', compact('reservations'));
    }

    public function show(RentalReservation $rentalReservation)
    {
        $rentalReservation->load(['rentalItem', 'order.user', 'orderItem']);

        return view('admin.rental-reservations.show', compact('rentalReservation'));
    }

    public function updateStatus(Request $request, RentalReservation $rentalReservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,active,completed,cancelled',
            'return_notes' => 'nullable|string',
            'return_condition' => 'nullable|string',
            'actual_return_date' => 'nullable|date',
        ]);

        $rentalReservation->update($validated);

        return redirect()->route('admin.rental-reservations.show', $rentalReservation)
            ->with('success', 'Statut de la réservation mis à jour avec succès.');
    }
}
