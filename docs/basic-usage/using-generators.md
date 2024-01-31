---
title: Using generators
sidebar_position: 1
---

Let's say you have migrated a `products` table with the following schema:

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

# Generating for a whole table

Now you can run any available generator for the table:

```bash
php artisan generate:factory products
```

The generator will inspect your schema and output relevant code using all your table columns:

```php
Schema-based factory for table "products" have been generated!
Copy & paste these to your factory class:
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

# Generating for specific columns

If you want to generate code using only a subset of your table's columns, you can use the `--columns` option to specify the columns:

```bash
php artisan generate:factory products --columns name,address
```

Now the code will be generated only using those columns:

```php
Schema-based factory for table "products" have been generated!
Copy & paste these to your factory class:
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
        ];
    }
}
```

# Generate files instead of outputting code

By default, all generators will output the generated code to the console. You can add a `--create` or `-c` flag, which will create or append to the relevant files for you.

```bash
php artisan generate:factory products --create
```

When using the `--create` flag, if any of the generated files already exists, the generator will refuse to overwrite the file. To force an overwrite, you can use the `--force` or `-f` flag.

```bash
php artisan generate:factory products --create --force
```

By default, the generator will figure out the relevant directory to put the generated file. If you want the files to be generated in a custom directory, you can use the `--path` option to specify a custom path relative to your project root.

```bash
php artisan generate:factory products --create --path database\\seeders
```

# Always skip columns

To always skip columns add it in the config file, under `skip_columns` parameter.

```php
'skip_columns' => ['whatever', 'some_other_column'],
```
