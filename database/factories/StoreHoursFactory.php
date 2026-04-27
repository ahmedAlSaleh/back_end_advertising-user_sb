<?php

namespace Database\Factories;

use App\Models\StoreHours;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreHours>
 */
class StoreHoursFactory extends Factory
{
    protected $model = StoreHours::class;

    /**
     * Define the model's default state.
     *
     * Creates store hours with realistic Iraqi business hours
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Days of the week in English (as per migration enum)
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $day = fake()->randomElement($days);

        // Most stores open between 8 AM and 10 AM
        $openingHours = ['08:00', '08:30', '09:00', '09:30', '10:00'];
        $opensAt = fake()->randomElement($openingHours);

        // Most stores close between 8 PM and 11 PM
        $closingHours = ['20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00'];
        $closesAt = fake()->randomElement($closingHours);

        // Most stores are open (only 10% chance of being closed)
        $isClosed = fake()->boolean(10);

        return [
            'store_id' => null, // Will be set by seeder
            'day' => $day,
            'opens_at' => $isClosed ? null : $opensAt,
            'closes_at' => $isClosed ? null : $closesAt,
            'is_closed' => $isClosed,
        ];
    }

    /**
     * Indicate that the store is open on this day
     */
    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'opens_at' => '09:00',
            'closes_at' => '22:00',
            'is_closed' => false,
        ]);
    }

    /**
     * Indicate that the store is closed on this day
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'opens_at' => null,
            'closes_at' => null,
            'is_closed' => true,
        ]);
    }

    /**
     * Set specific day of the week (English)
     */
    public function forDay(string $day): static
    {
        return $this->state(fn (array $attributes) => [
            'day' => $day,
        ]);
    }

    /**
     * Set Arabic day
     */
    public function forDayArabic(string $day): static
    {
        return $this->state(fn (array $attributes) => [
            'day' => $day,
        ]);
    }
}
