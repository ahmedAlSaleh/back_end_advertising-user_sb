<?php

namespace Database\Factories;

use App\Models\Block;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Block>
 */
class BlockFactory extends Factory
{
    protected $model = Block::class;

    /**
     * Define the model's default state.
     *
     * Creates blocks where users block stores, traders, or other users
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Types that can be blocked
        $blockedTypes = ['store', 'trader', 'user'];

        return [
            'user_id' => User::factory(), // Random user who is blocking
            'blocked_id' => null, // Will be set by seeder based on blocked_type
            'blocked_type' => fake()->randomElement($blockedTypes),
        ];
    }

    /**
     * Indicate that this is a block for a store
     */
    public function blockingStore(): static
    {
        return $this->state(fn (array $attributes) => [
            'blocked_type' => 'store',
        ]);
    }

    /**
     * Indicate that this is a block for a trader
     */
    public function blockingTrader(): static
    {
        return $this->state(fn (array $attributes) => [
            'blocked_type' => 'trader',
        ]);
    }

    /**
     * Indicate that this is a block for a user
     */
    public function blockingUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'blocked_type' => 'user',
        ]);
    }
}
