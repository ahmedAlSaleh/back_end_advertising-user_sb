<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Store;
use App\Models\Trader;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Collect possible addressable models
        $addressables = collect()
            ->merge(Store::all()->map(fn ($m) => ['id' => $m->id, 'type' => Store::class]))
            ->merge(Trader::all()->map(fn ($m) => ['id' => $m->id, 'type' => Trader::class]));

        // If none exist, nothing to attach to—early return
        if ($addressables->isEmpty()) {
            $this->command?->warn('No stores or traders found. Seed those first before AddressSeeder.');
            return;
        }

        // Create 10 addresses attached randomly to a store or trader
        for ($i = 0; $i < 10; $i++) {
            $target = $addressables->random();

            Address::create([
                'addressable_id'   => $target['id'],
                'addressable_type' => $target['type'],
                'street'           => $faker->streetAddress(),
                'city'             => $faker->city(),
                'state'            => $faker->state(),
                'country'          => $faker->country(),
                'postal_code'      => $faker->postcode(),
            ]);
        }
    }
}
