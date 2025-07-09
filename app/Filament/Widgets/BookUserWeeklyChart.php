<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BookUserWeeklyChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Buku & User per Minggu';

    protected function getData(): array
    {
        $weeks = collect(range(0, 11))->map(function ($week) {
            return now()->subWeeks($week)->startOfWeek()->format('W Y');
        })->reverse()->values();

        $bookData = Book::select(
            DB::raw('DATE_FORMAT(created_at, "%v %Y") as week'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subWeeks(11))
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->keyBy('week')
            ->map(fn ($item) => $item->total);

        $userData = User::select(
            DB::raw('DATE_FORMAT(created_at, "%v %Y") as week'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subWeeks(11))
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->keyBy('week')
            ->map(fn ($item) => $item->total);

        $bookCounts = $weeks->map(fn ($week) => $bookData->get($week, 0))->toArray();
        $userCounts = $weeks->map(fn ($week) => $userData->get($week, 0))->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Buku Baru',
                    'data' => $bookCounts,
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#10B981',
                ],
                [
                    'label' => 'User Baru',
                    'data' => $userCounts,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => '#3B82F6',
                ],
            ],
            'labels' => $weeks->toArray(),
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