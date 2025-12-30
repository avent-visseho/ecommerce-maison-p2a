<?php

namespace App\Http\Controllers;

use App\Models\RentalCategory;
use App\Models\RentalItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = RentalItem::active()->available()->with('rentalCategory');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('rental_category_id', $request->category);
        }

        // Filter by price range (daily rate)
        if ($request->filled('min_price')) {
            $query->where('daily_rate', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('daily_rate', '<=', $request->max_price);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('daily_rate', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('daily_rate', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }

        $rentalItems = $query->paginate(12);
        $categories = RentalCategory::active()->parent()->get();

        return view('public.rentals.index', compact('rentalItems', 'categories'));
    }

    public function show($slug)
    {
        $rentalItem = RentalItem::active()
            ->where('slug', $slug)
            ->with('rentalCategory')
            ->firstOrFail();

        // Increment views
        $rentalItem->incrementViews();

        // Similar rental items
        $similarItems = RentalItem::active()
            ->available()
            ->where('rental_category_id', $rentalItem->rental_category_id)
            ->where('id', '!=', $rentalItem->id)
            ->take(4)
            ->get();

        return view('public.rentals.show', compact('rentalItem', 'similarItems'));
    }

    public function checkAvailability(Request $request, $id)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
        ]);

        $rentalItem = RentalItem::findOrFail($id);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $quantity = $validated['quantity'];

        // Calculate duration in days (inclusive)
        $days = $startDate->diffInDays($endDate) + 1;

        // Check availability
        $available = $rentalItem->isAvailable($startDate, $endDate, $quantity);
        $availableQuantity = $rentalItem->getAvailableQuantity($startDate, $endDate);

        if (!$available) {
            return response()->json([
                'available' => false,
                'message' => "Désolé, seulement {$availableQuantity} unité(s) disponible(s) pour ces dates.",
                'available_quantity' => $availableQuantity
            ]);
        }

        // Calculate optimal pricing
        $pricing = $rentalItem->calculatePrice($days);

        return response()->json([
            'available' => true,
            'duration_days' => $days,
            'rate_type' => $pricing['rate_type'],
            'rate' => $pricing['rate'],
            'units' => $pricing['units'],
            'subtotal_per_item' => $pricing['subtotal'],
            'total' => $pricing['subtotal'] * $quantity,
            'deposit_per_item' => $rentalItem->deposit_amount,
            'total_deposit' => $rentalItem->deposit_amount * $quantity,
            'grand_total' => ($pricing['subtotal'] * $quantity) + ($rentalItem->deposit_amount * $quantity)
        ]);
    }
}
