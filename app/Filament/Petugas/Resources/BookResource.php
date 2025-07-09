<?php

namespace App\Filament\Petugas\Resources;

use App\Filament\Petugas\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                Forms\Components\FileUpload::make('cover')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->directory('book-covers')
                    ->visibility('public')
                    ->columnSpanFull(),
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
                Forms\Components\Select::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'dipinjam' => 'Dipinjam',
                        'rusak' => 'Rusak',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('active_status')
                    ->required()
                    ->default(true),
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
                Tables\Columns\TextColumn::make('category.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'dipinjam' => 'danger',
                        'terlambat' => 'danger',
                        'rusak' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
} 