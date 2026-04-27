<?php

namespace Database\Factories;

use App\Models\Trader;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trader>
 */
class TraderFactory extends Factory
{
    protected $model = Trader::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * Creates trader users with Iraqi phone formats and Arabic city names
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Major Iraqi cities in Arabic
        $iraqiCities = [
            'بغداد',      // Baghdad
            'البصرة',     // Basra
            'أربيل',      // Erbil
            'الموصل',     // Mosul
            'النجف',      // Najaf
            'كربلاء',     // Karbala
            'السليمانية', // Sulaymaniyah
            'كركوك',      // Kirkuk
            'الأنبار',    // Anbar
            'ديالى',      // Diyala
            'بابل',       // Babylon
            'نينوى',      // Nineveh
            'ذي قار',     // Dhi Qar
            'واسط',       // Wasit
        ];

        // Arabic store descriptions (some will be null)
        $descriptions = [
            'متجر متخصص في بيع المنتجات عالية الجودة',
            'نوفر أفضل الأسعار في السوق العراقي',
            'خدمة التوصيل متاحة لجميع المحافظات',
            'منتجات أصلية مع ضمان الجودة',
            'أكثر من 10 سنوات من الخبرة في السوق',
            'نقدم خدمات ما بعد البيع الممتازة',
            'أسعار تنافسية وعروض يومية',
            null, // Some traders won't have descriptions
            null,
        ];

        return [
            'owner_contact_number' => $this->generateIraqiPhone(),
            'password' => static::$password ??= Hash::make('password'),
            'whatsapp_number' => $this->generateIraqiPhone(),
            'telegram_number' => fake()->boolean(60) ? $this->generateIraqiPhone() : null, // 60% have telegram
            'social_media_link' => fake()->boolean(50) ? fake()->url() : null, // 50% have social media
            'store_id' => null, // Will be set by seeder
            'city' => fake()->randomElement($iraqiCities),
            'store_description' => fake()->randomElement($descriptions),
        ];
    }

    /**
     * Generate Iraqi phone number in format 07XX XXX XXXX
     */
    private function generateIraqiPhone(): string
    {
        $prefix = '07' . fake()->randomElement(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']);
        $part1 = fake()->numerify('###');
        $part2 = fake()->numerify('####');

        return "{$prefix}{$part1} {$part2}";
    }
}
