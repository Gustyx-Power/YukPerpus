<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\BookStats;
use App\Filament\Widgets\BorrowingStats;
use App\Filament\Widgets\RecentBorrowings;
use App\Filament\Widgets\BookUserChart;
use App\Filament\Widgets\PdfBooksTable;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected function getHeaderWidgets(): array
    {
        return [
            BookStats::class,
            BorrowingStats::class,
            BookUserChart::class,
            RecentBorrowings::class,
            PdfBooksTable::class,
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
} 