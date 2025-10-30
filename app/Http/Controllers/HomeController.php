<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $totalFeatured = Product::active()->featured()->count();
        $featuredProducts = Product::active()
            ->featured()
            ->inStock()
            ->with(['category', 'brand'])
            ->take(8)
            ->get();

        $categories = Category::active()
            ->parent()
            ->withCount('products')
            ->orderBy('order')
            ->take(6)
            ->get();

        $newProducts = Product::active()
            ->inStock()
            ->with(['category', 'brand'])
            ->latest()
            ->take(8)
            ->get();

        return view('public.home', compact('featuredProducts', 'categories', 'newProducts', 'totalFeatured'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function services()
    {
        return view('public.services');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you can send email or save to database
         //Mail::to('contact@lamaisonp2a.com')->send(new ContactMail($validated));

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons bientôt.');
    }
}
