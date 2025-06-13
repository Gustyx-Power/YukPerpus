<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getView(): string
    {
        return 'filament.custom-login';
    }

    public function getRedirectUrl(): string
    {
        $user = auth()->user();
        if ($user?->level === 'admin') {
            return '/admin';
        } elseif ($user?->level === 'petugas') {
            return '/petugas';
        } else {
            return '/user';
        }
    }
} 