<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'car_seats']);
        Category::create(['name' => 'feeding']);
        Category::create(['name' => 'gifts']);
        Category::create(['name' => 'strollers']);
    }
}
