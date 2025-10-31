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
        $validated = $request->validate([
            'email' => 'required|email|unique:blog_newsletters,email',
        ]);

        $newsletter = BlogNewsletter::create($validated);

        // Send verification email
        try {
            Mail::to($newsletter->email)->send(new NewsletterVerification($newsletter));
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }

        return back()->with('success', 'Merci ! Veuillez vérifier votre email pour confirmer votre inscription.');
    }

    public function verify($token)
    {
        $newsletter = BlogNewsletter::where('token', $token)->firstOrFail();

        if ($newsletter->isVerified()) {
            return redirect()->route('blog.index')->with('info', 'Votre email est déjà vérifié.');
        }

        $newsletter->verify();

        return redirect()->route('blog.index')->with('success', 'Votre inscription à la newsletter a été confirmée !');
    }

    public function unsubscribe($token)
    {
        $newsletter = BlogNewsletter::where('token', $token)->firstOrFail();

        $newsletter->unsubscribe();

        return redirect()->route('blog.index')->with('success', 'Vous avez été désabonné de la newsletter.');
    }
}
