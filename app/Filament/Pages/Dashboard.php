<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\BookStats;
use App\Filament\Widgets\BorrowingStats;
use App\Filament\Widgets\RecentBorrowings;
use App\Filament\Widgets\BookUserChart;
use App\Filament\Widgets\BookUserWeeklyChart;


class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'YukPerpus';

    protected function getHeaderWidgets(): array
    {
        return [
            BookStats::class,
            BorrowingStats::class,
            BookUserChart::class,
            BookUserWeeklyChart::class,
            RecentBorrowings::class,
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

    protected function getViewData(): array
    {
        return [
            ...parent::getViewData(),
            'showExportButtons' => true,
        ];
    }

    public function getWidgets(): array
    {
        return [];
    }
} 