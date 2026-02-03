<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 👇 CAMBIO AQUÍ: Redirección personalizada
        
        // Si quieres que SOLO el admin vaya al catálogo:
        if ($request->user()->role === 'admin') {
            return redirect()->route('catalog.all');
        }

        // Si quieres que los usuarios normales TAMBIÉN vayan al catálogo 
        // (lo más normal en una tienda), usa esta línea:
        return redirect()->intended(route('catalog.all'));

        // Si prefieres que los usuarios normales vayan al Dashboard original,
        // borra la línea de arriba y descomenta la de abajo:
        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}