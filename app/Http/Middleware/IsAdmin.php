<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Primero comprobamos si el usuario está logueado (Auth::check())
        // 2. Luego miramos si su columna 'role' es distinta de 'admin'
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            
            // Si no es admin o no está logueado, cortamos el paso con un error 403
            abort(403, 'ACCESO DENEGADO: No tienes permisos de administrador.');
        }

        // Si es admin, dejamos que la petición continúe
        return $next($request);
    }
}