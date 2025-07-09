<?php

namespace App\Filament\User\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Settings extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Auth::user()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('foto')
                    ->label('Profile Photo')
                    ->avatar()
                    ->image()
                    ->directory('profile-photos')
                    ->columnSpanFull(),
                TextInput::make('nama')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->autocomplete('current-password')
                    ->rules(['required_with:new_password']),
                TextInput::make('new_password')
                    ->label('New Password')
                    ->password()
                    ->autocomplete('new-password')
                    ->rules(['min:8', 'confirmed']),
                TextInput::make('new_password_confirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->autocomplete('new-password'),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();

        if (isset($data['current_password'])) {
            if (! Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->title('Incorrect current password!')
                    ->danger()
                    ->send();
                return;
            }
            $user->password = Hash::make($data['new_password']);
        }

        if (isset($data['foto'])) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $data['foto'];
        }

        $user->nama = $data['nama'];
        $user->email = $data['email'];

        $user->save();

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }
}