<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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

    // Provera tipa korisnika i preusmeravanje na odgovarajuću stranicu
    if (Auth::user()->user_type === 'moderator') {
        return redirect('/appointments');
    } elseif (Auth::user()->user_type === 'administrator') {
        return redirect(RouteServiceProvider::HOME);
    }

    // Podrazumevano preusmeravanje ako tip korisnika nije ni 'moderator' ni 'administrator'
    return redirect('/'); 
}

    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
