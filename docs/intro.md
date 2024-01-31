---
title: Introduction
sidebar_position: 1.0
---

# Generators

:::danger

This package is currently under development. If anything works, that's a surprise.

:::

[Generators](https://github.com/Javaabu/generators) provide Laravel generators on steroids based on database schemas.
For example, if you have a `products` table with the following schema:

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('address');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->unsignedDecimal('price', 14, 2);
    $table->unsignedInteger('stock');
    $table->boolean('on_sale')->default(false);
    $table->json('features');
    $table->dateTime('published_at');
    $table->timestamp('expire_at');
    $table->date('released_on');
    $table->time('sale_time');
    $table->enum('status', ['draft', 'published']);
    $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
    $table->year('manufactured_year');
    $table->timestamps();
    $table->softDeletes();
});
```

and you run the artisan command `php artisan generate:factory products --create` it will output the code for a `ProductFactory` like below:

```php
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

    public function withCategory(): ProductFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'category_id' => $this->faker->passThrough(random_id_or_generate(\App\Models\Category::class, 'id')),
            ];
        });
    }
}

```

