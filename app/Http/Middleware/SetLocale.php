<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Les langues supportées par l'application.
     *
     * @var array
     */
    protected $supportedLocales = ['fr', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifier si une langue est passée dans l'URL (ex: ?lang=en)
        if ($request->has('lang') && in_array($request->lang, $this->supportedLocales)) {
            $locale = $request->lang;
            Session::put('locale', $locale);
        }
        // 2. Sinon, vérifier si une langue est stockée en session
        elseif (Session::has('locale') && in_array(Session::get('locale'), $this->supportedLocales)) {
            $locale = Session::get('locale');
        }
        // 3. Sinon, utiliser la langue par défaut de l'application
        else {
            $locale = config('app.locale', 'fr');
            Session::put('locale', $locale);
        }

        // Définir la langue de l'application
        App::setLocale($locale);

        // Définir la langue pour Carbon (dates)
        if (class_exists(\Carbon\Carbon::class)) {
            \Carbon\Carbon::setLocale($locale);
        }

        return $next($request);
    }
}
