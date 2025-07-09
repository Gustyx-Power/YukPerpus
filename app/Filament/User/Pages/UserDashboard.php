<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\BorrowingStats;
use App\Filament\Widgets\RecentBorrowings;

class UserDashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard Pengguna';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\User\Widgets\WelcomeWidget::class,
            RecentBorrowings::class,
            \App\Filament\User\Widgets\NewBooksWidget::class,
        ];
    }

    public function getRedirectUrl(): string
    {
        return '/user';
    }

    public function getWidgets(): array
    {
        return [];
    }
}
