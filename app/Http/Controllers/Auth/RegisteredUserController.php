<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation de base (format, confirmation mot de passe, etc.)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Vérification spécifique : email déjà utilisé → message clair avec suggestion de connexion
        if (User::where('email', $request->email)->exists()) {
            return back()->withInput()->with('email_already_exists', true);
        }

        $customerRole = Role::where('slug', 'customer')->first();

        if (!$customerRole) {
            return back()->withErrors([
                'email' => __('messages.auth.config_error'),
            ])->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $customerRole->id,
            ]);
        } catch (\Illuminate\Database\UniqueConstraintException $e) {
            // Sécurité en cas de condition de course
            return back()->withInput()->with('email_already_exists', true);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
