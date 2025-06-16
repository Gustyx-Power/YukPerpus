<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class RecentBorrowings extends BaseWidget
{
    protected static ?string $heading = 'Peminjaman Terbaru';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peminjam')
                    ->sortable(),
                TextColumn::make('book.judul')
                    ->label('Buku')
                    ->sortable(),
                TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->date()
                    ->sortable(),
                TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'reserved' => 'warning',
                        'dipinjam' => 'primary',
                        'dikembalikan' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getDefaultColumnSpan(): int
    {
        return 6;
    }
} 