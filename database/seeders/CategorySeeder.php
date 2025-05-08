<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Electrónica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'test4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'test3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'test2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'test1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}