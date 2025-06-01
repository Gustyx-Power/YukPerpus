<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Book;
use App\Models\Fine; // Tambahkan ini untuk mengakses model Fine

class ReportController extends Controller
{
    public function generateBookReport()
    {
        // Ambil semua data buku dari database
        $books = Book::all();

        // Initialize Dompdf with options
        $options = new Options();
        // Sebaiknya gunakan DejaVu Sans untuk konsistensi dan dukungan karakter
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);

        // Load HTML content, dan kirim data $books ke view
        $html = view('reports.book', compact('books'))->render();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        return $dompdf->stream('book_report.pdf');
    }

    public function generateFineReport()
    {
        // Ambil semua data denda dari database
        // Gunakan eager loading untuk mengambil data relasi (loan, user, book)
        // untuk menghindari N+1 query problem
        $fines = Fine::with(['loan.user', 'loan.book'])->get();

        // Initialize Dompdf with options
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans'); // Menggunakan DejaVu Sans
        $dompdf = new Dompdf($options);

        // Load HTML content, dan kirim data $fines ke view
        $html = view('reports.fine', compact('fines'))->render();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        return $dompdf->stream('fine_report.pdf');
    }
}
