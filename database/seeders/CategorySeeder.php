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
            'Desarrollo Web',
            'Diseño web',
            'Desarrollo Móvil',
            'Desarrollo de Videojuegos',
            'Diseño de Videjuegos'
        ];

        foreach($categories as $category){
            Category::create([
                'name' => $category
            ]);
       
        }

    }
}
