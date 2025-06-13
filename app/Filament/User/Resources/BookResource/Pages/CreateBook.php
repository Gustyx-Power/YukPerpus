<?php

namespace App\Filament\User\Resources\BookResource\Pages;

use App\Filament\User\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;
}
