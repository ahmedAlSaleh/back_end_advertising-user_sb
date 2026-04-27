<?php

namespace Database\Factories;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    /**
     * Define the model's default state.
     *
     * Creates advertisements with mixed Arabic/English titles and realistic Iraqi pricing
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mixed Arabic and English advertisement titles
        $arabicTitles = [
            'للبيع - هاتف آيفون 13 برو جديد',
            'شقة للإيجار في بغداد - موقع مميز',
            'سيارة تويوتا 2020 للبيع',
            'أثاث منزلي مستعمل بحالة ممتازة',
            'خدمات صيانة الكترونيات',
            'محل تجاري للإيجار في البصرة',
            'كمبيوتر محمول Dell جديد',
            'مطلوب موظفين للعمل في شركة',
            'ملابس رجالية بأسعار مخفضة',
            'قطع غيار سيارات أصلية',
        ];

        $englishTitles = [
            'For Sale - Brand New iPhone 13 Pro',
            'Apartment for Rent in Baghdad - Prime Location',
            'Toyota 2020 Car for Sale',
            'Used Home Furniture in Excellent Condition',
            'Electronics Maintenance Services',
            'Commercial Shop for Rent in Basra',
            'New Dell Laptop',
            'Job Vacancy - Company Hiring',
            'Men\'s Clothing at Discounted Prices',
            'Original Car Spare Parts',
        ];

        // Arabic descriptions
        $arabicDescriptions = [
            'منتج جديد بالكرتون لم يستخدم من قبل. السعر قابل للتفاوض. للاستفسار الرجاء الاتصال على الرقم المذكور.',
            'عرض مميز لفترة محدودة. جودة عالية وأسعار منافسة. خدمة التوصيل متاحة لجميع المحافظات.',
            'حالة ممتازة جداً. تم الحفاظ عليه بشكل جيد. السعر نهائي غير قابل للتفاوض.',
            'منتج أصلي مع ضمان لمدة سنة. يمكن الاستلام من المحل أو التوصيل للمنزل.',
            'أفضل الأسعار في السوق. تخفيضات كبيرة. لا تفوت هذه الفرصة الذهبية.',
            'خدمة احترافية وسريعة. فريق عمل متخصص. أسعار مناسبة للجميع.',
            'موقع استراتيجي قريب من جميع الخدمات. مساحة واسعة ومريحة.',
            'عرض خاص لهذا الأسبوع فقط. اتصل الآن واحصل على خصم إضافي.',
        ];

        // Randomly choose between Arabic and English title
        $useArabic = fake()->boolean(75); // 75% chance of Arabic title
        $title = $useArabic
            ? fake()->randomElement($arabicTitles)
            : fake()->randomElement($englishTitles);

        // Advertisement types (as per migration enum: normal, special)
        $types = ['normal', 'special'];
        $type = fake()->randomElement($types);

        // Status - mostly active
        $statuses = ['draft', 'scheduled', 'active', 'active', 'active', 'active', 'active', 'expired', 'paused'];
        $status = fake()->randomElement($statuses);

        // Featured ads (20% chance)
        $isFeatured = fake()->boolean(20);
        $featuredUntil = $isFeatured ? now()->addDays(7) : null;
        $featureType = $isFeatured ? fake()->randomElement(['basic', 'premium']) : 'none';

        // Scheduling
        $scheduledAt = fake()->boolean(30) ? fake()->dateTimeBetween('-7 days', '+7 days') : null;

        // Expiration (most ads expire after 30 days)
        $expiresAt = fake()->boolean(80) ? now()->addDays(30) : null;

        return [
            'title' => $title,
            'description' => fake()->randomElement($arabicDescriptions),
            'notes' => fake()->boolean(40) ? fake()->sentence() : null, // 40% have notes
            'price' => fake()->numberBetween(10000, 999999), // Iraqi Dinar (10k to 999k - decimal(8,2) limit)
            'trader_id' => null, // Will be set by seeder
            'type' => $type,
            'is_featured' => $isFeatured,
            'featured_until' => $featuredUntil,
            'feature_type' => $featureType,
            'scheduled_at' => $scheduledAt,
            'expires_at' => $expiresAt,
            'status' => $status,
        ];
    }

    /**
     * Indicate that the advertisement is featured
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'featured_until' => now()->addDays(7),
            'feature_type' => fake()->randomElement(['basic', 'premium']),
        ]);
    }

    /**
     * Indicate that the advertisement is active
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the advertisement is normal type
     */
    public function normal(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'normal',
        ]);
    }

    /**
     * Indicate that the advertisement is special type
     */
    public function special(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'special',
        ]);
    }
}
