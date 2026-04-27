<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * Creates categories with Arabic names and placeholder images
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Main categories in Arabic
        $categoryNames = [
            'إلكترونيات',           // Electronics
            'ملابس وأزياء',         // Clothes and Fashion
            'أثاث ومفروشات',        // Furniture
            'طعام ومشروبات',        // Food and Beverages
            'سيارات ومركبات',       // Cars and Vehicles
            'عقارات',              // Real Estate
            'خدمات',               // Services
            'رياضة وترفيه',         // Sports and Entertainment
            'كتب وقرطاسية',         // Books and Stationery
            'صحة وجمال',            // Health and Beauty
            'ألعاب وهدايا',         // Toys and Gifts
            'حيوانات أليفة',        // Pets
            'أدوات منزلية',         // Home Tools
            'مجوهرات وإكسسوارات',   // Jewelry and Accessories
            'موبايلات وتابلت',      // Mobiles and Tablets
        ];

        return [
            'name' => fake()->unique()->randomElement($categoryNames),
            'image' => 'https://picsum.photos/400/400?random=' . fake()->unique()->numberBetween(1, 10000),
        ];
    }
}
