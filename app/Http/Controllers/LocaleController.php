<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    // Método para cambiar el idioma de la aplicación
    public function changeLocale($locale)
    {
        // Determina el nuevo idioma basándose en el idioma actual
        $newLocale = $locale === "es" ? 'en' : 'es';

        // Almacena el nuevo idioma en la sesión
        session()->put('locale', $newLocale);

        // Redirige al usuario de vuelta a la página anterior
        return Redirect::back();
    }
}
