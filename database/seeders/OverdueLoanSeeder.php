<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;

class OverdueLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get an existing user and book
        $user = User::first();
        $book = Book::first();

        if ($user && $book) {
            // Create an overdue loan
            Loan::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'tanggal_pinjam' => Carbon::now()->subDays(30), // Borrowed 30 days ago
                'tanggal_kembali' => Carbon::now()->subDays(15), // Was due 15 days ago
                'status' => 'terlambat',
            ]);

            $this->command->info('Overdue loan seeded successfully.');
        } else {
            $this->command->warn('Could not seed overdue loan: Make sure you have at least one user and one book in your database.');
        }
    }
}
