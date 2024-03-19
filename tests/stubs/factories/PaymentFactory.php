<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, -99999999999, 99999999999),
            'status' => fake()->optional()->randomElement(array_column(\App\Enums\PaymentStatuses::cases(), 'value')),
        ];
    }

    public function withOrder(): PaymentFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'order_id' => fake()->unique()->passThrough(random_id_or_generate(\App\Models\Order::class, 'id', generate: true, unique: true)),
            ];
        });
    }

    public function withRequiredRelations(): PaymentFactory
    {
        return $this->withOrder();
    }
}
