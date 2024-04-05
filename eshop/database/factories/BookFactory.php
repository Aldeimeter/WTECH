<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence;
        return [
            'name' => $name,
            'slug' => Str::slug($name,'-'),
            'price' => $this->faker->randomFloat(2, 10, 50), // Generates a random price between 10 and 50
            'language' => $this->faker->randomElement(['SVK', 'ENG']),
            'publish_date' => $this->faker->date(),
            'description' => $this->faker->paragraph,

        ];
    }
}
