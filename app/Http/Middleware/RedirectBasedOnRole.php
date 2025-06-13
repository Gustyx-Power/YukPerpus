<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Redirect berdasarkan level
        switch ($user->level) {
            case 'admin':
                return redirect('/admin');
            case 'petugas':
                return redirect('/petugas');
            case 'anggota':
                return redirect('/user');
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Role tidak valid');
        }
    }
} 