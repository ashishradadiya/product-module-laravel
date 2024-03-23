<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Log;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed categories
        try {
            Category::factory()->count(10)->create();
            // Log success message
            Log::info('Category seeding completed successfully.');
        } catch (\Exception $e) {
            // Log error message
            Log::error('Error occurred while seeding categories: ' . $e->getMessage());
        }
    }
}
