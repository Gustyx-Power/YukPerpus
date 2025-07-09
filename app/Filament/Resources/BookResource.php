<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

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
                    ->searchable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pengarang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penerbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_terbit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_halaman')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('lokasi_rak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'dipinjam' => 'warning',
                        'rusak' => 'danger',
                        'terlambat' => 'danger',
                    }),
                Tables\Columns\IconColumn::make('active_status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_pdf')
                        ->visible(fn (): bool => auth()->user()->isAdmin() || auth()->user()->isPetugas())
                        ->label('Download PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (Collection $records) {
                            $records->load('category'); // Eager load category to prevent N+1 problem
                            $pdf = Pdf::loadView('pdf.books', ['books' => $records]);
                            return response()->streamDownload(function () use ($pdf) {
                                echo $pdf->stream();
                            }, 'laporan-buku.pdf');
                        }),
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

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\BookStats::class,
            \App\Filament\Widgets\BorrowingStats::class,
            \App\Filament\Widgets\RecentBorrowings::class,
        ];
    }
}
