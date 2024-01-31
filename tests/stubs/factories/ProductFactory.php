<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'address' => $this->faker->address(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->optional()->sentences(3, true),
            'price' => $this->faker->randomFloat(2, 0, 999999999999),
            'stock' => $this->faker->numberBetween(0, 4294967295),
            'on_sale' => $this->faker->boolean(),
            'features' => $this->faker->passThrough($this->faker->words()),
            'published_at' => $this->faker->dateTime()?->format('Y-m-d H:i'),
            'expire_at' => $this->faker->dateTime()?->format('Y-m-d H:i'),
            'released_on' => $this->faker->date(),
            'sale_time' => $this->faker->time(),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'manufactured_year' => $this->faker->year(2100),
        ];
    }

    public function withCateogry(): ProductFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'category_id' => $this->faker->passThrough(random_id_or_generate(\App\Models\Category::class, 'id')),
            ];
        });
    }
}
