<?php

namespace Database\Factories;

use App\Models\PromotionPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromotionPackage>
 */
class PromotionPackageFactory extends Factory
{
    protected $model = PromotionPackage::class;

    /**
     * Define the model's default state.
     *
     * Creates promotion packages with Arabic names and realistic Iraqi pricing
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Package configurations (name, duration, price)
        $packages = [
            ['name' => 'باقة برونزية', 'duration' => 7, 'price' => 100],      // Bronze Package
            ['name' => 'باقة فضية', 'duration' => 14, 'price' => 200],        // Silver Package
            ['name' => 'باقة ذهبية', 'duration' => 30, 'price' => 500],       // Gold Package
            ['name' => 'باقة البداية', 'duration' => 3, 'price' => 50],       // Starter Package
            ['name' => 'باقة الأعمال', 'duration' => 60, 'price' => 900],     // Business Package
            ['name' => 'باقة المميزة', 'duration' => 90, 'price' => 1200],    // Premium Package
        ];

        $package = fake()->randomElement($packages);

        // Benefits descriptions in Arabic
        $benefitsOptions = [
            [
                'ظهور في الصفحة الرئيسية',
                'أولوية في نتائج البحث',
                'شارة "مميز" على الإعلان',
            ],
            [
                'ظهور في أعلى القائمة',
                'تسليط الضوء على الإعلان',
                'إحصائيات مفصلة',
                'دعم فني مجاني',
            ],
            [
                'أفضل موقع في الصفحة',
                'ظهور في جميع الصفحات ذات الصلة',
                'شارة ذهبية',
                'تقارير أسبوعية',
                'دعم فني متقدم',
            ],
        ];

        return [
            'name' => $package['name'],
            'duration_days' => $package['duration'],
            'price_points' => $package['price'],
            'benefits' => fake()->randomElement($benefitsOptions),
            'is_active' => fake()->boolean(90), // 90% are active
        ];
    }

    /**
     * Indicate that the package is a gold package
     */
    public function gold(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'باقة ذهبية',
            'duration_days' => 30,
            'price_points' => 500,
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the package is a silver package
     */
    public function silver(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'باقة فضية',
            'duration_days' => 14,
            'price_points' => 200,
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the package is a bronze package
     */
    public function bronze(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'باقة برونزية',
            'duration_days' => 7,
            'price_points' => 100,
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the package is inactive
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
