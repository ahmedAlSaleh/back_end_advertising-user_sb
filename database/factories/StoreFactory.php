<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * Creates stores with mixed Arabic/English names and placeholder images
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mixed Arabic and English store names
        $arabicStoreNames = [
            'متجر الإلكترونيات الحديثة',
            'مركز الأزياء العصرية',
            'محل الأثاث الفاخر',
            'سوبر ماركت الخليج',
            'معرض السيارات المتحدة',
            'مكتبة النور',
            'صيدلية الشفاء',
            'مطعم بغداد',
            'محل الهدايا والتحف',
            'مركز الكمبيوتر والموبايل',
        ];

        $englishStoreNames = [
            'Modern Electronics Store',
            'Fashion Center',
            'Luxury Furniture Shop',
            'Gulf Supermarket',
            'United Car Showroom',
            'Al Noor Bookstore',
            'Al Shifa Pharmacy',
            'Baghdad Restaurant',
            'Gifts & Antiques Shop',
            'Computer & Mobile Center',
        ];

        // Arabic owner names
        $ownerNames = [
            'أحمد محمد علي',
            'علي حسن محمود',
            'محمد صالح أحمد',
            'حسن علي حسين',
            'سعيد محمود علي',
            'خالد أحمد حسن',
            'عمر محمد سعيد',
            'ياسر علي محمد',
            'فارس حسن علي',
            'طارق محمود أحمد',
        ];

        // Randomly choose between Arabic and English store name
        $useArabic = fake()->boolean(70); // 70% chance of Arabic store name
        $storeName = $useArabic
            ? fake()->randomElement($arabicStoreNames)
            : fake()->randomElement($englishStoreNames);

        return [
            'store_name' => $storeName,
            'store_owner_name' => fake()->randomElement($ownerNames),
            'store_number' => $this->generateIraqiPhone(),
            'image' => 'https://picsum.photos/800/600?random=' . fake()->unique()->numberBetween(1, 10000),
            'category_id' => null, // Will be set by seeder
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
