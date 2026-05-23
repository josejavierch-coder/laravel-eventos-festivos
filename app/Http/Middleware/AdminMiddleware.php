<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Si está autenticado pero no es admin, redirigir a inicio con mensaje
        return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}
