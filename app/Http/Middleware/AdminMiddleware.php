<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Maneja la solicitud comprobando si el usuario es administrador.
     */
    public function handle(Request $request, Closure $next)
    {
        // Se asume que el modelo User tiene un atributo booleano "is_admin"
        if (!$request->user() || !$request->user()->is_admin) {
            abort(403, 'Acceso no autorizado.');
        }
        return $next($request);
    }
}