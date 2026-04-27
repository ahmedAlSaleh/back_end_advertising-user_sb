<?php

namespace Database\Factories;

use App\Models\RechargeCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RechargeCode>
 */
class RechargeCodeFactory extends Factory
{
    protected $model = RechargeCode::class;

    /**
     * Define the model's default state.
     *
     * Creates recharge codes with unique codes and Iraqi Dinar amounts
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Common recharge amounts in Iraqi Dinar
        $amounts = [10000, 20000, 50000, 100000, 200000, 500000];
        $amount = fake()->randomElement($amounts);

        // Generate unique 10-character uppercase code
        // Format: XXXX-XXXX-XX for better readability
        $code = $this->generateUniqueCode();

        // Most codes are unused (80% unused, 20% used)
        $isUsed = fake()->boolean(20);

        // Point number (same as amount for simplicity)
        $pointNumber = $amount;

        return [
            'code' => $code,
            'price' => $amount,
            'is_used' => $isUsed,
            'point_number' => $pointNumber,
        ];
    }

    /**
     * Generate a unique recharge code
     * Format: XXXX-XXXX-XX (10 characters without dashes)
     */
    private function generateUniqueCode(): string
    {
        return strtoupper(Str::random(10));
    }

    /**
     * Indicate that the code is unused
     */
    public function unused(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_used' => false,
        ]);
    }

    /**
     * Indicate that the code is used
     */
    public function used(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_used' => true,
        ]);
    }

    /**
     * Set a specific amount
     */
    public function amount(int $amount): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => $amount,
            'point_number' => $amount,
        ]);
    }

    /**
     * Create a 10,000 IQD code
     */
    public function small(): static
    {
        return $this->amount(10000);
    }

    /**
     * Create a 50,000 IQD code
     */
    public function medium(): static
    {
        return $this->amount(50000);
    }

    /**
     * Create a 100,000 IQD code
     */
    public function large(): static
    {
        return $this->amount(100000);
    }

    /**
     * Create a 500,000 IQD code
     */
    public function xlarge(): static
    {
        return $this->amount(500000);
    }
}
