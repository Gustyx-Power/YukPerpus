<?php

namespace App\Http\Middleware;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class FilamentAuthenticate extends Middleware
{
    protected function redirectTo($request): string
    {
        if (! $request->expectsJson()) {
            return '/login';
        }
    }
} 