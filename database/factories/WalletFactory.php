<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * Creates wallets with Iraqi Dinar balances
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Balance in Iraqi Dinar (0 to 500,000 IQD)
        $balance = fake()->numberBetween(0, 500000);

        return [
            'balance' => $balance,
            'trader_id' => null, // Will be set by seeder
        ];
    }

    /**
     * Indicate that the wallet has a high balance
     */
    public function wealthy(): static
    {
        return $this->state(fn (array $attributes) => [
            'balance' => fake()->numberBetween(300000, 1000000),
        ]);
    }

    /**
     * Indicate that the wallet has zero balance
     */
    public function empty(): static
    {
        return $this->state(fn (array $attributes) => [
            'balance' => 0,
        ]);
    }

    /**
     * Indicate that the wallet has a low balance
     */
    public function low(): static
    {
        return $this->state(fn (array $attributes) => [
            'balance' => fake()->numberBetween(0, 50000),
        ]);
    }
}
