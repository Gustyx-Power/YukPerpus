<?php

namespace App\Filament\Petugas\Resources;

use App\Filament\Petugas\Resources\LoanResource\Pages;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function getNavigationGroup(): ?string
    {
        return 'Peminjaman';
    }

    public static function getNavigationLabel(): string
    {
        return 'Reservasi Buku';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'judul')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\DatePicker::make('tanggal_pinjam')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_kembali')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_dikembalikan')
                    ->hidden(fn (?string $operation) => $operation === 'create'),
                Forms\Components\Select::make('status')
                    ->options([
                        'reserved' => 'Reserved',
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.judul')
                    ->label('Buku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'reserved' => 'warning',
                        'dipinjam' => 'primary',
                        'dikembalikan' => 'success',
                        'dibatalkan' => 'danger',
                        'terlambat' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'reserved')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'dipinjam'
                        ]);
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('Peminjaman berhasil disetujui'),
                Tables\Actions\Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('primary')
                    ->visible(fn ($record) => $record->status === 'dipinjam')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'dikembalikan',
                            'tanggal_dikembalikan' => now(),
                        ]);
                        // Update status buku
                        $record->book->increment('stok');
                        if ($record->book->stok > 0) {
                            $record->book->update(['status' => 'tersedia']);
                        }
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('Buku berhasil dikembalikan!'),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
} 