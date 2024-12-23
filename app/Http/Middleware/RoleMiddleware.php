<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verifica si el usuario está autenticado y tiene el rol requerido
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }
        

        // Si no tiene acceso, redirigir
        return redirect('/home-users')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}