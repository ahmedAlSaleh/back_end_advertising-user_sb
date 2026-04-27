<?php

namespace Database\Factories;

use App\Models\Rate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rate>
 */
class RateFactory extends Factory
{
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * Creates ratings for advertisements, stores, or traders
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Types that can be rated
        $ratedTypes = ['advertisement', 'store', 'trader'];

        // Rating from 1 to 5 (weighted towards higher ratings)
        $ratingDistribution = [1, 2, 3, 3, 4, 4, 4, 5, 5, 5, 5, 5];
        $rating = fake()->randomElement($ratingDistribution);

        // Arabic comments (required - based on rating)
        $comments = [
            'ممتاز',
            'جيد جداً',
            'رائع',
            'مقبول',
            'يحتاج تحسين',
            'خدمة سريعة',
            'جودة عالية',
            'أسعار مناسبة',
            'تجربة جيدة',
            'موصى به',
            'خدمة ممتازة',
        ];

        return [
            'user_id' => User::factory(), // Random user
            'rated_id' => null, // Will be set by seeder
            'rated_type' => fake()->randomElement($ratedTypes),
            'rate' => $rating,
            'comment' => fake()->randomElement($comments),
        ];
    }

    /**
     * Indicate that this is a rating for an advertisement
     */
    public function forAdvertisement(): static
    {
        return $this->state(fn (array $attributes) => [
            'rated_type' => 'advertisement',
        ]);
    }

    /**
     * Indicate that this is a rating for a store
     */
    public function forStore(): static
    {
        return $this->state(fn (array $attributes) => [
            'rated_type' => 'store',
        ]);
    }

    /**
     * Indicate that this is a rating for a trader
     */
    public function forTrader(): static
    {
        return $this->state(fn (array $attributes) => [
            'rated_type' => 'trader',
        ]);
    }

    /**
     * Indicate that the rating is high (4-5 stars)
     */
    public function high(): static
    {
        return $this->state(fn (array $attributes) => [
            'rate' => fake()->numberBetween(4, 5),
        ]);
    }

    /**
     * Indicate that the rating is low (1-2 stars)
     */
    public function low(): static
    {
        return $this->state(fn (array $attributes) => [
            'rate' => fake()->numberBetween(1, 2),
        ]);
    }
}
