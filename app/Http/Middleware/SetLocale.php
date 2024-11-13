<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Language;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->locale;

        // Obtiene el idioma desde la base de datos utilizando el `iso`
        $language = Language::getCachedLanguageByIso($locale);

        if ($language) {
            App::setLocale($locale); // Configura el idioma en la aplicación
            Session::put('locale', $locale); // Guarda el idioma en la sesión
        } else {
            // Si el idioma no es válido, redirige al idioma predeterminado
            $defaultLanguage = Language::getDefault();
            return redirect()->to("/{$defaultLanguage->iso}" . $request->getPathInfo());
        }

        return $next($request);
    }
}
