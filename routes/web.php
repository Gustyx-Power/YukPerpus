<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookBrowseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectBasedOnRole;

// Root route redirects to login
Route::get('/', function () {
    return redirect('/login');
});

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard route with role-based redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();

        switch ($user->level) {
            case 'admin':
                return redirect('/admin');
            case 'petugas':
                return redirect('/petugas');
            case 'anggota':
                return redirect('/user');
            default:
                return redirect('/login');
        }
    })->name('dashboard')->middleware(RedirectBasedOnRole::class);

    // Book browsing routes (accessible to all authenticated users)
    Route::get('/browse', [BookBrowseController::class, 'index'])->name('books.browse');

    // Book management routes (admin and petugas only)
    Route::middleware(['role:admin', 'role:petugas'])->group(function () {
        Route::resource('books', BookController::class);
        Route::resource('categories', CategoryController::class);
    });

    // Loan routes
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
    Route::post('/loans/{loan}/cancel', [LoanController::class, 'cancel'])->name('loans.cancel');

    // User routes (admin only)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    

    // Report generation routes (admin and petugas only)
    Route::middleware(['role:admin', 'role:petugas'])->group(function () {
        Route::get('/reports/books', [ReportController::class, 'books'])->name('reports.books');
        Route::get('/reports/loans', [ReportController::class, 'loans'])->name('reports.loans');
        Route::get('/reports/users', [ReportController::class, 'users'])->name('reports.users');
    });
});

// Social Login Routes
Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('auth/github', [SocialLoginController::class, 'redirectToGithub'])->name('auth.github');
Route::get('auth/github/callback', [SocialLoginController::class, 'handleGithubCallback'])->name('auth.github.callback');

Route::post('/book-borrow/store', function(Request $request) {
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
    ]);

    // Cek stok buku
    $book = Book::findOrFail($request->book_id);
    if ($book->stok <= 0) {
        return redirect()->back()->with('error', 'Maaf, stok buku tidak tersedia!');
    }

    // Cek apakah user sudah mencapai batas maksimum peminjaman (3 buku)
    $activeLoans = Loan::where('user_id', Auth::id())
        ->whereIn('status', ['reserved', 'dipinjam'])
        ->count();

    if ($activeLoans >= 3) {
        return redirect()->back()->with('error', 'Anda telah mencapai batas maksimum peminjaman (3 buku)');
    }

    // Buat record peminjaman
    $loan = Loan::create([
        'user_id' => Auth::id(),
        'book_id' => $request->book_id,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali' => $request->tanggal_kembali,
        'keterangan' => $request->keterangan,
        'status' => 'dipinjam',
    ]);

    // Update stok buku (kurangi 1)
    $book->decrement('stok');

    // Update status buku berdasarkan stok
    if ($book->stok === 0) {
        $book->update(['status' => 'dipinjam']);
    }

    return redirect()->back()->with('success', 'Peminjaman berhasil disimpan!');
})->name('rakbuku.store')->middleware('auth');

// Handle login submission
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
    ->middleware('web')
    ->name('login.store');

// Handle logout
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
