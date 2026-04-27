<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\Trader;
use App\Models\Wallet;
use App\Models\Post;
use App\Models\Advertisement;   // <-- add
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TraderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $perStore = 2; // tweak as needed

        Store::all()->each(function (Store $store) use ($faker, $perStore) {
            for ($i = 0; $i < $perStore; $i++) {
                $trader = Trader::create([
                    'owner_contact_number' => $faker->unique()->numerify('###########'),
                    'password'             => Hash::make('password'),
                    'whatsapp_number'      => $faker->optional()->numerify('###########'),
                    'telegram_number'      => $faker->optional()->numerify('###########'),
                    'social_media_link'    => $faker->optional()->url(),
                    'store_id'             => $store->id,
                ]);

                // Wallet
                Wallet::create([
                    'trader_id' => $trader->id,
                    'balance'   => $faker->randomFloat(2, 0, 5000),
                ]);

                // 3 Posts
                for ($p = 1; $p <= 3; $p++) {
                    Post::create([
                        'title'     => $faker->sentence(4),
                        'trader_id' => $trader->id,
                    ]);
                }

                // 3 Advertisements
                for ($a = 1; $a <= 3; $a++) {
                    Advertisement::create([
                        'title'       => $faker->sentence(5),
                        'description' => $faker->paragraph(),
                        'notes'       => $faker->optional()->sentence(),
                        'price'       => $faker->randomFloat(2, 5, 2000),
                        'trader_id'   => $trader->id,
                    ]);
                }
            }
        });
    }
}
