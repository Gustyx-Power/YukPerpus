<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Credits extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static string $view = 'filament.pages.credits';

    protected static ?string $navigationGroup = 'About';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Credits';

    public array $developers = [
        [
            'name' => 'Dimas Dwi Ariyanto',
            'photo' => 'https://avatars.githubusercontent.com/u/94319420?s=400&u=125abcf57357a58a0025b9f7f8ecaca1827f72e0&v=4', // Actual photo for Dimas
            'github' => 'pavelc4',
            'telegram' => '@Pavellc',
        ],
        [
            'name' => 'Gusti Aditya Muzaky',
            'photo' => 'https://github.com/Gustyx-Power.png?s=400',
            'github' => 'Gustyx-Power',
            'telegram' => '@GustyxPower',
        ],
    ];
}
