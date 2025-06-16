<?php

namespace App\Filament\User\Resources\BookResource\Pages;

use App\Filament\User\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada header actions untuk user
        ];
    }
}
