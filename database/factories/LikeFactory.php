<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * Creates likes/dislikes for posts (mutually exclusive)
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // User either likes or dislikes, not both
        $isLike = fake()->boolean(70); // 70% likes, 30% dislikes

        return [
            'post_id' => null, // Will be set by seeder
            'user_id' => User::factory(), // Random user
            'like' => $isLike,
            'dislike' => !$isLike, // Opposite of like
        ];
    }

    /**
     * Indicate that this is a like
     */
    public function liked(): static
    {
        return $this->state(fn (array $attributes) => [
            'like' => true,
            'dislike' => false,
        ]);
    }

    /**
     * Indicate that this is a dislike
     */
    public function disliked(): static
    {
        return $this->state(fn (array $attributes) => [
            'like' => false,
            'dislike' => true,
        ]);
    }
}
