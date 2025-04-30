<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Level;
use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{

    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'status' => 3,
            'image_path' => 'courses/images/' . $this->faker->image('public/storage/courses', 640, 480, null, false),


            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'level_id' => Level::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'price_id' => Price::all()->random()->id,

            /* 'user_id' => 2,


            'level_id' => Level::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'price_id' => Price::all()->random()->id */

        ];
    }
}
