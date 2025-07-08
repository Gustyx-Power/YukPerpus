<?php

namespace App\Filament\User\Resources\LoanResource\Pages;

use App\Filament\User\Resources\LoanResource;
use App\Filament\Widgets\BookCards;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoans extends ListRecords
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Pinjam Buku')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            //
        ];
    }
}
