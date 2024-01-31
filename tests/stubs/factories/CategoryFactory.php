<?php

namespace Javaabu\Generators\Tests\stubs\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use function Database\Factories\random_id_or_generate;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->passThrough(ucfirst($this->faker->text(255))),
            'slug' => $this->faker->unique()->slug(),
        ];
    }

}
