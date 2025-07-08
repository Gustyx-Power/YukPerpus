<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class MonthlyStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the last 12 months
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);

            // Create some books for this month
            Book::factory()->count(rand(5, 15))->create([
                'created_at' => $date->copy()->startOfMonth()->addDays(rand(0, $date->daysInMonth - 1)),
            ]);

            // Create some users for this month
            User::factory()->count(rand(2, 8))->create([
                'created_at' => $date->copy()->startOfMonth()->addDays(rand(0, $date->daysInMonth - 1)),
            ]);
        }

        $this->command->info('Monthly stats data seeded successfully.');
    }
}
