<?php

namespace Database\Factories;

use App\Models\View;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\View>
 */
class ViewFactory extends Factory
{
    protected $model = View::class;

    /**
     * Define the model's default state.
     *
     * Creates views for advertisements, stores, or posts
     * Can be from logged-in users or guest views (null user_id)
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Types that can be viewed
        $viewableTypes = ['Advertisement', 'Store', 'Post'];

        // Common user agents for realistic data
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (iPad; CPU OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
            'Mozilla/5.0 (Android 14; Mobile; rv:121.0) Gecko/121.0 Firefox/121.0',
        ];

        // 60% of views are from logged-in users, 40% are guest views
        $userId = fake()->boolean(60) ? User::factory() : null;

        return [
            'viewable_type' => 'App\\Models\\' . fake()->randomElement($viewableTypes),
            'viewable_id' => null, // Will be set by seeder
            'user_id' => $userId,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->randomElement($userAgents),
        ];
    }

    /**
     * Indicate that this is a view from a logged-in user
     */
    public function authenticated(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory(),
        ]);
    }

    /**
     * Indicate that this is a guest view (no user_id)
     */
    public function guest(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
        ]);
    }

    /**
     * Indicate that this is a view for an advertisement
     */
    public function forAdvertisement(): static
    {
        return $this->state(fn (array $attributes) => [
            'viewable_type' => 'App\\Models\\Advertisement',
        ]);
    }

    /**
     * Indicate that this is a view for a store
     */
    public function forStore(): static
    {
        return $this->state(fn (array $attributes) => [
            'viewable_type' => 'App\\Models\\Store',
        ]);
    }

    /**
     * Indicate that this is a view for a post
     */
    public function forPost(): static
    {
        return $this->state(fn (array $attributes) => [
            'viewable_type' => 'App\\Models\\Post',
        ]);
    }

    /**
     * Set a recent view timestamp
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}
