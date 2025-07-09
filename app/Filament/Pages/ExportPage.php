<?php

namespace App\Filament\Pages;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.export-page';

    protected static ?string $title = 'Export Data';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Actions::make([
                    Action::make('export_books_pdf')
                        ->label('Export All Books to PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action('exportBooksPdf'),
                    Action::make('export_loans_pdf')
                        ->label('Export All Loans to PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action('exportLoansPdf'),
                ])
            ]);
    }

    public function exportBooksPdf(): StreamedResponse
    {
        $records = Book::all(); // Get all books
        $records->load('category'); // Eager load category to prevent N+1 problem

        $pdf = PDF::loadView('pdf.books', ['books' => $records]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-buku-semua.pdf');
    }

    public function exportLoansPdf(): StreamedResponse
    {
        $records = Loan::all(); // Get all loans
        $records->load(['book', 'user']); // Eager load book and user to prevent N+1 problem

        $pdf = PDF::loadView('pdf.loans', ['loans' => $records]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-peminjaman-semua.pdf');
    }

    public function exportUsersPdf(): StreamedResponse
    {
        $records = User::all(); // Get all users

        $pdf = PDF::loadView('pdf.users', ['users' => $records]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-pengguna-semua.pdf');
    }
}