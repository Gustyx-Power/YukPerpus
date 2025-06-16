<?php

namespace App\Filament\User\Resources\LoanResource\Pages;

use App\Filament\User\Resources\LoanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = 'reserved';

        // Kurangi stok buku
        $book = \App\Models\Book::find($data['book_id']);
        $book->decrement('stok');
        if ($book->stok === 0) {
            $book->update(['status' => 'dipinjam']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
