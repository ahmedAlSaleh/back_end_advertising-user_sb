<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * Creates posts with mixed Arabic/English titles
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mixed Arabic and English post titles
        $arabicTitles = [
            'عروض خاصة لهذا الأسبوع',
            'وصول منتجات جديدة إلى المتجر',
            'تخفيضات كبيرة على جميع المنتجات',
            'احتفال بافتتاح الفرع الجديد',
            'خدمة التوصيل المجاني لفترة محدودة',
            'أحدث موديلات الهواتف الذكية',
            'عرض خاص بمناسبة رمضان',
            'منتجات حصرية غير متوفرة في مكان آخر',
            'شكراً لثقتكم - أكثر من 1000 عميل راضٍ',
            'خصومات تصل إلى 50% على مختارات خاصة',
            'افتتاح معرض جديد في بغداد',
            'ورشة عمل مجانية للمهتمين',
            'مسابقة وجوائز قيمة للفائزين',
            'تجديد المحل بالكامل',
            'أحدث صيحات الموضة لهذا الموسم',
        ];

        $englishTitles = [
            'Special Offers This Week',
            'New Products Arrived in Store',
            'Huge Discounts on All Products',
            'Celebrating New Branch Opening',
            'Free Delivery for Limited Time',
            'Latest Smartphone Models Available',
            'Special Ramadan Offer',
            'Exclusive Products Not Available Elsewhere',
            'Thank You for Your Trust - 1000+ Satisfied Customers',
            'Discounts Up to 50% on Selected Items',
            'New Showroom Opening in Baghdad',
            'Free Workshop for Interested People',
            'Contest with Valuable Prizes',
            'Complete Store Renovation',
            'Latest Fashion Trends This Season',
        ];

        // Randomly choose between Arabic and English title (70% Arabic)
        $useArabic = fake()->boolean(70);
        $title = $useArabic
            ? fake()->randomElement($arabicTitles)
            : fake()->randomElement($englishTitles);

        return [
            'title' => $title,
            'trader_id' => null, // Will be set by seeder
        ];
    }
}
