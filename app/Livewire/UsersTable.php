<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Contracts\TranslatableContentDriver;
use Livewire\Component;

class UsersTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('name')->label('Nama'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('level')->label('Role'),
            ]);
    }

    public function render()
    {
        return view('livewire.users-table');
    }
}