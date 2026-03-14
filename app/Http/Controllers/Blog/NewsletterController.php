<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogNewsletter;
use App\Mail\NewsletterVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Vérification spécifique : email déjà inscrit → message clair
        if (BlogNewsletter::where('email', $request->email)->exists()) {
            return back()->with('error', __('messages.newsletter.already_subscribed'));
        }

        $newsletter = BlogNewsletter::create(['email' => $request->email]);

        // Send verification email
        try {
            Mail::to($newsletter->email)->send(new NewsletterVerification($newsletter));
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }

        return back()->with('success', __('messages.newsletter.subscribed'));
    }

    public function verify($token)
    {
        $newsletter = BlogNewsletter::where('token', $token)->firstOrFail();

        if ($newsletter->isVerified()) {
            return redirect()->route('blog.index')->with('info', __('messages.newsletter.already_verified'));
        }

        $newsletter->verify();

        return redirect()->route('blog.index')->with('success', __('messages.newsletter.verified'));
    }

    public function unsubscribe($token)
    {
        $newsletter = BlogNewsletter::where('token', $token)->firstOrFail();

        $newsletter->unsubscribe();

        return redirect()->route('blog.index')->with('success', __('messages.newsletter.unsubscribed'));
    }
}
