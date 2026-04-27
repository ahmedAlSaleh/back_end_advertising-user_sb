<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * Creates admin users with mixed Arabic/English names and Iraqi phone format
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mixed Arabic and English names for realistic data
        $arabicNames = ['أحمد محمد', 'علي حسن', 'محمد علي', 'حسن أحمد', 'سارة محمود', 'فاطمة علي', 'زينب حسن'];
        $englishNames = ['Ahmed Mohammed', 'Ali Hassan', 'Mohammed Ali', 'Hassan Ahmed', 'Sara Mahmoud', 'Fatima Ali', 'Zainab Hassan'];

        // Randomly choose between Arabic and English name
        $useArabic = fake()->boolean(60); // 60% chance of Arabic name
        $name = $useArabic
            ? fake()->randomElement($arabicNames)
            : fake()->randomElement($englishNames);

        return [
            'name' => $name,
            'phone' => $this->generateIraqiPhone(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
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
