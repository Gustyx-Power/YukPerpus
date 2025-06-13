<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class BookBorrow extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.book-borrow';
}
