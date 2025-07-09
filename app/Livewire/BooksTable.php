<?php

namespace App\Livewire;

use App\Models\Book;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Contracts\TranslatableContentDriver;
use Livewire\Component;

class BooksTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Book::query())
            ->columns([
                TextColumn::make('judul')->label('Judul'),
                TextColumn::make('pengarang')->label('Pengarang'),
                TextColumn::make('penerbit')->label('Penerbit'),
                TextColumn::make('tahun_terbit')->label('Tahun Terbit'),
                TextColumn::make('stok')->label('Stok'),
                TextColumn::make('category.nama')->label('Kategori')->default(''),
            ]);
    }

    public function render()
    {
        return view('livewire.books-table');
    }
}