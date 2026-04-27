<?php

namespace Database\Factories;

use App\Models\RechargeOperation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RechargeOperation>
 */
class RechargeOperationFactory extends Factory
{
    protected $model = RechargeOperation::class;

    /**
     * Define the model's default state.
     *
     * Creates recharge operations (recharge, purchase, refund) with Arabic descriptions
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Operation types as per migration enum: form_code, from_admin
        $types = ['form_code', 'from_admin'];
        $type = fake()->randomElement($types);

        // Amount based on type
        if ($type === 'form_code') {
            // Amounts for code recharge
            $amount = fake()->randomElement([10000, 20000, 50000, 100000, 200000, 500000]);
        } else {
            // Amounts for admin recharge
            $amount = fake()->randomElement([10000, 20000, 50000, 100000, 200000, 500000]);
        }

        // Code is required - generate for all types
        $code = strtoupper(fake()->bothify('??????????'));

        return [
            'trader_id' => null, // Will be set by seeder
            'code' => $code,
            'type' => $type,
            'amount' => $amount,
        ];
    }

    /**
     * Indicate that this is a form_code operation
     */
    public function fromCode(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'form_code',
            'amount' => fake()->randomElement([10000, 20000, 50000, 100000, 200000, 500000]),
            'code' => strtoupper(fake()->bothify('??????????')),
        ]);
    }

    /**
     * Indicate that this is a from_admin operation
     */
    public function fromAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'from_admin',
            'amount' => fake()->randomElement([10000, 20000, 50000, 100000, 200000, 500000]),
            'code' => strtoupper(fake()->bothify('??????????')),
        ]);
    }

    /**
     * Set a specific amount
     */
    public function withAmount(int $amount): static
    {
        return $this->state(fn (array $attributes) => [
            'amount' => $amount,
        ]);
    }
}
