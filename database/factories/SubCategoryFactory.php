<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategory>
 */
class SubCategoryFactory extends Factory
{
    protected $model = SubCategory::class;

    /**
     * Define the model's default state.
     *
     * Creates subcategories with Arabic names
     * Category ID should be set by seeder based on parent category
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Subcategory names in Arabic (generic ones that can fit multiple categories)
        $subCategoryNames = [
            // Electronics subcategories
            'هواتف ذكية',           // Smartphones
            'حواسيب محمولة',        // Laptops
            'تلفزيونات',            // TVs
            'كاميرات',              // Cameras
            'سماعات',               // Headphones

            // Clothing subcategories
            'ملابس رجالية',         // Men's Clothing
            'ملابس نسائية',         // Women's Clothing
            'ملابس أطفال',          // Children's Clothing
            'أحذية',                // Shoes
            'حقائب',                // Bags

            // Furniture subcategories
            'غرف نوم',              // Bedrooms
            'غرف جلوس',             // Living Rooms
            'مطابخ',                // Kitchens
            'مكاتب',                // Offices

            // Food subcategories
            'مخبوزات',              // Bakery
            'مشروبات',              // Beverages
            'لحوم ودواجن',          // Meat and Poultry
            'خضروات وفواكه',        // Vegetables and Fruits

            // Cars subcategories
            'سيارات جديدة',         // New Cars
            'سيارات مستعملة',       // Used Cars
            'قطع غيار',             // Spare Parts
            'إكسسوارات سيارات',     // Car Accessories

            // Real Estate subcategories
            'شقق للبيع',            // Apartments for Sale
            'منازل للإيجار',        // Houses for Rent
            'محلات تجارية',         // Commercial Shops
            'أراضي',                // Lands

            // Services subcategories
            'خدمات تنظيف',          // Cleaning Services
            'خدمات صيانة',          // Maintenance Services
            'خدمات توصيل',          // Delivery Services
            'خدمات تعليمية',        // Educational Services

            // Other generic subcategories
            'منتجات مستوردة',       // Imported Products
            'منتجات محلية',         // Local Products
            'عروض خاصة',            // Special Offers
            'تخفيضات',              // Discounts
        ];

        return [
            'name' => fake()->randomElement($subCategoryNames),
            'category_id' => null, // Will be set by seeder
        ];
    }
}
