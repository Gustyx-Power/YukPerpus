<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Tables\Actions\Action;

class BorrowingStats extends BaseWidget
{
    protected static ?int $sort = 2;

    public static function getDefaultColumnSpan(): int
    {
        return 6;
    }

    protected function getHeading(): string
    {
        return 'Statistik Peminjaman';
    }

    protected function getStats(): array
    {
        $totalBorrowings = Loan::count();
        $activeBorrowings = Loan::where('status', 'dipinjam')->count();
        $overdueBorrowings = Loan::where('status', 'terlambat')->count();
        $returnedBorrowings = Loan::where('status', 'dikembalikan')->count();

        return [
            Stat::make('Total Peminjaman', $totalBorrowings)
                ->description('Jumlah keseluruhan peminjaman')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Sedang Dipinjam', $activeBorrowings)
                ->description('Peminjaman aktif')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Terlambat', $overdueBorrowings)
                ->description('Peminjaman terlambat')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
            Stat::make('Dikembalikan', $returnedBorrowings)
                ->description('Peminjaman yang sudah dikembalikan')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view_pdf')
                ->label('Lihat PDF')
                ->icon('heroicon-o-document')
                ->url(fn ($record) => $record->pdf_file ? \Storage::url($record->pdf_file) : null)
                ->openUrlInNewTab()
                ->visible(fn ($record) => !empty($record->pdf_file)),
        ];
    }
} 