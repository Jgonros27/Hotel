<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y es un administrador
        if ($request->user() && ($request->user()->admin === 1)) {
            // Si es un administrador, permite que la solicitud continúe
            return $next($request);
        }

        // Si el usuario no es un administrador, le redirige a /acceso-denegado
        return redirect()->route('acceso-denegado');
    }
}
