<?php

namespace App\Filament\User\Widgets;

use App\Models\Book;
use Filament\Widgets\Widget;

class NewBooksWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.new-books-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Buku Terbaru';

    protected function getViewData(): array
    {
        $books = Book::latest()->limit(5)->get();

        return [
            'books' => $books,
        ];
    }
}