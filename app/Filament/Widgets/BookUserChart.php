<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BookUserChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Buku & User per Bulan';

    protected function getData(): array
    {
        $months = collect(range(0, 11))->map(function ($month) {
            return now()->subMonths($month)->format('M Y');
        })->reverse();

        $bookData = Book::select(
            DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(11))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $userData = User::select(
            DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(11))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Buku Baru',
                    'data' => $months->map(fn ($month) => $bookData[$month] ?? 0)->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#10B981',
                ],
                [
                    'label' => 'User Baru',
                    'data' => $months->map(fn ($month) => $userData[$month] ?? 0)->toArray(),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => '#3B82F6',
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public static function getDefaultColumnSpan(): int
    {
        return 6;
    }
} 