<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getNavigationGroup(): ?string
    {
        return 'Perpustakaan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Daftar Buku';
    }

    public static function getPluralLabel(): string
    {
        return 'Buku';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(191)
                    ->default(null),
                Forms\Components\TextInput::make('pengarang')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('penerbit')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('tahun_terbit')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_halaman')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cover')
                    ->maxLength(191)
                    ->default(null),
                Forms\Components\TextInput::make('stok')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'nama')
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('lokasi_rak')
                    ->maxLength(191)
                    ->default(null),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('active_status')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('CompanyCode')
                    ->maxLength(20)
                    ->default(null),
                Forms\Components\TextInput::make('IsDeleted')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('CreatedBy')
                    ->maxLength(32)
                    ->default(null),
                Forms\Components\DateTimePicker::make('CreatedDate'),
                Forms\Components\TextInput::make('LastUpdatedBy')
                    ->maxLength(32)
                    ->default(null),
                Forms\Components\DateTimePicker::make('LastUpdatedDate'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->square(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pengarang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penerbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_terbit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'dipinjam' => 'warning',
                        'rusak' => 'danger',
                        'terlambat' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('pinjam')
                    ->label('Pinjam')
                    ->icon('heroicon-o-bookmark')
                    ->color('primary')
                    ->visible(fn ($record) => $record->stok > 0)
                    ->action(function ($record) {
                        // Redirect ke halaman peminjaman
                        return redirect()->route('user.loans.create', ['book_id' => $record->id]);
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
        ];
    }
}
