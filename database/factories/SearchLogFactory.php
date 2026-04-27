<?php

namespace Database\Factories;

use App\Models\SearchLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SearchLog>
 */
class SearchLogFactory extends Factory
{
    protected $model = SearchLog::class;

    /**
     * Define the model's default state.
     *
     * Creates search logs with mixed Arabic/English keywords and realistic filters
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Common search keywords in Arabic and English
        $arabicKeywords = [
            'هاتف',
            'آيفون',
            'سيارة',
            'شقة للإيجار',
            'أثاث',
            'لابتوب',
            'كمبيوتر',
            'ملابس',
            'أحذية',
            'ساعة',
            'تلفزيون',
            'مكيف',
            'عقار',
            'محل',
            'خدمات',
        ];

        $englishKeywords = [
            'phone',
            'iphone',
            'car',
            'apartment',
            'furniture',
            'laptop',
            'computer',
            'clothes',
            'shoes',
            'watch',
            'tv',
            'ac',
            'property',
            'shop',
            'services',
        ];

        // Randomly choose between Arabic and English keyword (70% Arabic)
        $useArabic = fake()->boolean(70);
        $keyword = $useArabic
            ? fake()->randomElement($arabicKeywords)
            : fake()->randomElement($englishKeywords);

        // Iraqi cities
        $iraqiCities = [
            'بغداد',
            'البصرة',
            'أربيل',
            'الموصل',
            'النجف',
            'كربلاء',
            'السليمانية',
            'كركوك',
            null, // Some searches don't filter by city
            null,
        ];

        // Sort options
        $sortByOptions = ['price', 'date', 'rating', 'views', null];
        $sortOrderOptions = ['asc', 'desc', null];

        // 50% of searches are from logged-in users
        $userId = fake()->boolean(50) ? fake()->numberBetween(1, 100) : null;

        // Price ranges (nullable for searches without price filter)
        $hasPriceFilter = fake()->boolean(40); // 40% of searches have price filter
        $priceMin = $hasPriceFilter ? fake()->randomElement([0, 10000, 50000, 100000, 500000]) : null;
        $priceMax = $hasPriceFilter && $priceMin ? $priceMin + fake()->randomElement([50000, 100000, 500000, 1000000]) : null;

        // Rating filter (nullable)
        $ratingMin = fake()->boolean(30) ? fake()->randomElement([3, 4, 4.5]) : null; // 30% filter by rating

        // Results count (0-50)
        $resultsCount = fake()->numberBetween(0, 50);

        return [
            'keyword' => $keyword,
            'category_id' => fake()->boolean(50) ? fake()->numberBetween(1, 15) : null, // 50% filter by category
            'sub_category_id' => fake()->boolean(30) ? fake()->numberBetween(1, 50) : null, // 30% filter by subcategory
            'city' => fake()->randomElement($iraqiCities),
            'price_min' => $priceMin,
            'price_max' => $priceMax,
            'rating_min' => $ratingMin,
            'sort_by' => fake()->randomElement($sortByOptions),
            'sort_order' => fake()->randomElement($sortOrderOptions),
            'results_count' => $resultsCount,
            'user_ip' => fake()->ipv4(),
            'user_id' => $userId,
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'), // Recent searches
        ];
    }

    /**
     * Indicate that the search is from a logged-in user
     */
    public function authenticated(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => fake()->numberBetween(1, 100),
        ]);
    }

    /**
     * Indicate that the search is from a guest
     */
    public function guest(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
        ]);
    }

    /**
     * Indicate that the search has many results
     */
    public function withResults(): static
    {
        return $this->state(fn (array $attributes) => [
            'results_count' => fake()->numberBetween(10, 50),
        ]);
    }

    /**
     * Indicate that the search has no results
     */
    public function noResults(): static
    {
        return $this->state(fn (array $attributes) => [
            'results_count' => 0,
        ]);
    }

    /**
     * Indicate that the search is recent (last 7 days)
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }

    /**
     * Set a specific keyword
     */
    public function withKeyword(string $keyword): static
    {
        return $this->state(fn (array $attributes) => [
            'keyword' => $keyword,
        ]);
    }
}
