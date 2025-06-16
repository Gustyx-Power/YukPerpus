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
        
        // Clear any previous intended URL
        $request->session()->forget('url.intended');

        // Redirect berdasarkan level user
        $user = Auth::user();
        switch ($user->level) {
            case 'admin':
                return redirect('/admin');
            case 'petugas':
                return redirect('/petugas');
            case 'anggota':
                return redirect('/user');
            default:
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Level user tidak valid.',
                ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Clear the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear any stored intended URL
        $request->session()->forget('url.intended');

        return redirect('/login');
    }
}
