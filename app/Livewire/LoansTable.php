<?php

namespace App\Livewire;

use App\Models\Loan;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Contracts\TranslatableContentDriver;
use Livewire\Component;

class LoansTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Loan::query())
            ->columns([
                TextColumn::make('id')->label('ID Peminjaman'),
                TextColumn::make('book.judul')->label('Judul Buku')->default(''),
                TextColumn::make('user.name')->label('Peminjam')->default(''),
                TextColumn::make('tanggal_pinjam')->label('Tanggal Peminjaman'),
                TextColumn::make('tanggal_kembali')->label('Tanggal Pengembalian'),
                TextColumn::make('status')->label('Status'),
            ]);
    }

    public function render()
    {
        return view('livewire.loans-table');
    }
}