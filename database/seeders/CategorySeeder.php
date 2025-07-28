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
        $categories = [
            'Álgebra',
            'Geometría',
            'Análisis real',
            'Probabilidad y Estadística',
            'Bachillerato',
            'Universidad',
            'Secundaria',
            'Matemáticas discretas',
            'IT',
            'Fundamentos'

        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category
            ]);
        }
    }
}
