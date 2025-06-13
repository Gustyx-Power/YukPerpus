<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Hapus file PDF lama jika ada file baru diupload
        if (isset($data['pdf_file']) && $data['pdf_file'] && $this->record->pdf_file && $data['pdf_file'] !== $this->record->pdf_file) {
            Storage::disk('public')->delete($this->record->pdf_file);
        }
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
