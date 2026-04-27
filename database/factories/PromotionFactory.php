<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    /**
     * Define the model's default state.
     *
     * Creates promotions with realistic date ranges based on package duration
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Typical package durations and prices
        $packageData = [
            ['duration' => 7, 'price' => 100],
            ['duration' => 14, 'price' => 200],
            ['duration' => 30, 'price' => 500],
        ];

        $selectedPackage = fake()->randomElement($packageData);

        // Start date - either now or in the recent past (last 30 days)
        $startedAt = fake()->dateTimeBetween('-30 days', 'now');

        // Calculate expiration based on package duration
        $expiresAt = (clone $startedAt)->modify("+{$selectedPackage['duration']} days");

        return [
            'advertisement_id' => null, // Will be set by seeder
            'package_id' => null, // Will be set by seeder
            'started_at' => $startedAt,
            'expires_at' => $expiresAt,
            'points_paid' => $selectedPackage['price'],
        ];
    }

    /**
     * Indicate that the promotion is currently active
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'started_at' => now()->subDays(fake()->numberBetween(1, 10)),
            'expires_at' => now()->addDays(fake()->numberBetween(5, 25)),
        ]);
    }

    /**
     * Indicate that the promotion has expired
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'started_at' => now()->subDays(fake()->numberBetween(40, 60)),
            'expires_at' => now()->subDays(fake()->numberBetween(1, 10)),
        ]);
    }

    /**
     * Indicate that the promotion will start in the future
     */
    public function upcoming(): static
    {
        $startDate = now()->addDays(fake()->numberBetween(1, 7));

        return $this->state(fn (array $attributes) => [
            'started_at' => $startDate,
            'expires_at' => (clone $startDate)->addDays(7),
        ]);
    }
}
