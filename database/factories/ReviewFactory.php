<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * Creates reviews with Arabic comments and ratings
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Arabic review comments (positive and negative)
        $positiveComments = [
            'ممتاز جداً، أنصح بالتعامل معهم',
            'خدمة رائعة وسريعة، شكراً جزيلاً',
            'منتجات عالية الجودة وأسعار مناسبة',
            'تجربة رائعة، سأتعامل معهم مرة أخرى بالتأكيد',
            'احترافية عالية في التعامل والخدمة',
            'أفضل متجر تعاملت معه، جودة ممتازة',
            'خدمة التوصيل سريعة والمنتج كما وصف تماماً',
            'صراحة فوق التوقعات، ممتازين',
            'تعامل راقي واحترام للعميل',
            'الله يبارك فيهم، خدمة ممتازة',
        ];

        $neutralComments = [
            'جيد بشكل عام، لكن يمكن التحسين',
            'خدمة مقبولة، لا بأس بها',
            'المنتج جيد لكن التوصيل كان متأخر قليلاً',
            'تجربة عادية، لا جديد',
            'السعر مناسب لكن الجودة متوسطة',
        ];

        $negativeComments = [
            'تجربة سيئة للأسف، لا أنصح بالتعامل',
            'المنتج لم يكن كما في الوصف',
            'خدمة سيئة وتأخير كبير في التوصيل',
            'عدم احترافية في التعامل',
            'للأسف لم تكن التجربة جيدة',
        ];

        // Rating from 1 to 5 (weighted towards higher ratings)
        $ratingDistribution = [1, 2, 3, 3, 4, 4, 4, 5, 5, 5, 5, 5];
        $rating = fake()->randomElement($ratingDistribution);

        // Choose comment based on rating
        if ($rating >= 4) {
            $comment = fake()->randomElement($positiveComments);
        } elseif ($rating == 3) {
            $comment = fake()->randomElement($neutralComments);
        } else {
            $comment = fake()->randomElement($negativeComments);
        }

        return [
            'reviewable_id' => null, // Will be set by seeder
            'reviewable_type' => null, // Will be set by seeder
            'user_id' => User::factory(), // Random user
            'rating' => $rating,
            'review' => $comment, // Note: The model uses 'review' not 'comment'
        ];
    }

    /**
     * Indicate that the review is positive (4-5 stars)
     */
    public function positive(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(4, 5),
        ]);
    }

    /**
     * Indicate that the review is negative (1-2 stars)
     */
    public function negative(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(1, 2),
        ]);
    }

    /**
     * Indicate that the review is neutral (3 stars)
     */
    public function neutral(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 3,
        ]);
    }

    /**
     * Set a specific rating
     */
    public function withRating(int $rating): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => $rating,
        ]);
    }
}
