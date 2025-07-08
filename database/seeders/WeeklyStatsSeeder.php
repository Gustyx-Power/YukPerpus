<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class WeeklyStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the last 12 weeks
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subWeeks($i);

            // Create some books for this week
            Book::factory()->count(rand(1, 5))->create([
                'created_at' => $date->copy()->startOfWeek()->addDays(rand(0, 6)),
            ]);

            // Create some users for this week
            User::factory()->count(rand(1, 3))->create([
                'created_at' => $date->copy()->startOfWeek()->addDays(rand(0, 6)),
            ]);
        }

        $this->command->info('Weekly stats data seeded successfully.');
    }
}
