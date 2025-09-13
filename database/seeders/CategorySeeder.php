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
        Category::create([
            'name' => 'Artificial Intelligence',
            'slug' => 'ai',
            'color' => 'bg-red-100'
        ]);

        Category::create([
            'name' => 'Web Designer',
            'slug' => 'web-designer',
            'color' => 'bg-green-100'
        ]);

        Category::create([
            'name' => 'Cloud Engineer',
            'slug' => 'cloud-engineer',
            'color' => 'bg-blue-100'
        ]);
    }
}
