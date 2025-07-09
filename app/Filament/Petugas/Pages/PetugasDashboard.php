<?php

namespace App\Filament\Petugas\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\BookStats;
use App\Filament\Widgets\BorrowingStats;
use App\Filament\Widgets\BookUserChart;
use App\Filament\Widgets\BookUserWeeklyChart;

class PetugasDashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard Petugas';

    protected function getHeaderWidgets(): array
    {
        return [
            BookStats::class,
            BorrowingStats::class,
            BookUserChart::class,
            BookUserWeeklyChart::class,
        ];
    }

    public function getRedirectUrl(): string
    {
        $user = auth()->user();
        if ($user->level === 'admin') {
            return '/admin';
        } elseif ($user->level === 'petugas') {
            return '/petugas';
        } else {
            return '/user';
        }
    }

    public function getWidgets(): array
    {
        return [];
    }
}
