<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Level;
use App\Models\Price;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('courses');

        Storage::makeDirectory('courses/images');

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Irving',
            'email' => 'riosirving04@gmail.com',
            'password' => bcrypt('1234')
        ]);

        $this->call([
            CategorySeeder::class,
            LevelSeeder::class,
            PriceSeeder::class
        ]);

        // Crear datos base
        User::factory()->count(5)->create();


        Course::factory(30)->create();
    }
}
