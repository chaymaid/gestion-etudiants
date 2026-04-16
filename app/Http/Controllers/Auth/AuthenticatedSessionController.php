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
     * Afficher la page login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Traiter login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentification
        $request->authenticate();

        // Sécurité (évite session hijacking)
        $request->session()->regenerate();

        // Redirection propre vers dashboard
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Invalider session
        $request->session()->invalidate();

        // Regénérer token CSRF
        $request->session()->regenerateToken();

        // Retour accueil
        return redirect('/');
    }
}
