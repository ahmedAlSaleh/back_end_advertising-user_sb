<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * Creates favorites for posts, stores, traders, or advertisements
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Types of entities that can be favorited
        $favoriteTypes = ['posts', 'stores', 'traders', 'advertisements'];

        return [
            'user_id' => User::factory(), // Random user
            'favorite_id' => null, // Will be set by seeder based on favorite_type
            'favorite_type' => fake()->randomElement($favoriteTypes),
        ];
    }

    /**
     * Indicate that this is a favorite for a post
     */
    public function forPost(): static
    {
        return $this->state(fn (array $attributes) => [
            'favorite_type' => 'posts',
        ]);
    }

    /**
     * Indicate that this is a favorite for a store
     */
    public function forStore(): static
    {
        return $this->state(fn (array $attributes) => [
            'favorite_type' => 'stores',
        ]);
    }

    /**
     * Indicate that this is a favorite for a trader
     */
    public function forTrader(): static
    {
        return $this->state(fn (array $attributes) => [
            'favorite_type' => 'traders',
        ]);
    }

    /**
     * Indicate that this is a favorite for an advertisement
     */
    public function forAdvertisement(): static
    {
        return $this->state(fn (array $attributes) => [
            'favorite_type' => 'advertisements',
        ]);
    }
}
