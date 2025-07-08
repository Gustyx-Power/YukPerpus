<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookStats extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function getDefaultColumnSpan(): int
    {
        return 6;
    }

    protected function getHeading(): string
    {
        return 'Statistik Buku';
    }

    protected function getStats(): array
    {
        $totalBooks = Book::count();
        $availableBooks = Book::where('status', 'tersedia')->count();
        $borrowedBooks = Book::where('status', 'dipinjam')->count();
        $damagedBooks = Book::where('status', 'rusak')->count();

        return [
            Stat::make('Total Buku', $totalBooks)
                ->description('Jumlah keseluruhan buku')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'),
            Stat::make('Buku Tersedia', $availableBooks)
                ->description('Buku yang bisa dipinjam')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
            Stat::make('Buku Dipinjam', $borrowedBooks)
                ->description('Buku yang sedang dipinjam')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
            Stat::make('Buku Rusak', $damagedBooks)
                ->description('Buku yang rusak')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
    }
} 