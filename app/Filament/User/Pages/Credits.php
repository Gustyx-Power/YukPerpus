<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;

class Credits extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    protected static string $view = 'filament.pages.credits';

    protected static ?string $navigationGroup = 'About';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Credits';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () use ($table) {
                $contributors = $this->getContributors();
                return \App\Filament\Tables\QueryBuilders\GitHubContributorsEloquentBuilder::fromCollection(
                    \Illuminate\Support\Collection::make($contributors)
                );
            })
            ->columns([
                TextColumn::make('login')
                    ->label('Contributor'),
                TextColumn::make('contributions')
                    ->label('Commits'),
            ]);
    }

    protected function getContributors(): array
    {
        $response = Http::get('https://api.github.com/repos/pavelc/YukPerpus/contributors');

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }
}