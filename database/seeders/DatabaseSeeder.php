<?php

namespace Database\Seeders;

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

        User::factory()->create([
            'name' => 'admin',
            'email' => 'riosirving04@gmail.com',
            'password' => bcrypt('1234')
        ]);

        $this->call([
            CategorySeeder::class,
            LevelSeeder::class,
            PriceSeeder::class,
            CourseSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            TimeSlotSeeder::class

        ]);
    }
}
