<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    /**
     * Manejar la solicitud entrante.
     */
    public function handle(Request $request, Closure $next)
    {
        // Suponiendo que is_admin es true para admin y false para clientes
        if (Auth::check() && !Auth::user()->is_admin) {
            return $next($request);
        }
        abort(403, 'Acceso no autorizado.');
    }
}
