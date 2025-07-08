<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\LoanResource\Pages;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function getNavigationGroup(): ?string
    {
        return 'Perpustakaan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Reservasi Buku';
    }

    public static function getPluralLabel(): string
    {
        return 'Peminjaman';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'judul')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->visible(fn () => !request()->has('book_id')),
                Forms\Components\DatePicker::make('tanggal_pinjam')
                    ->required()
                    ->default(now())
                    ->minDate(now()),
                Forms\Components\DatePicker::make('tanggal_kembali')
                    ->required()
                    ->default(now()->addDays(7))
                    ->minDate(fn ($get) => $get('tanggal_pinjam')),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Actions\Action::make('cancel')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === 'reserved')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'dibatalkan'
                        ]);
                        // Kembalikan stok buku
                        $record->book->increment('stok');
                        if ($record->book->stok > 0) {
                            $record->book->update(['status' => 'tersedia']);
                        }
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('Peminjaman berhasil dibatalkan'),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
        ];
    }
}
