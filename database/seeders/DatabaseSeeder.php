<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\Trader;
use App\Models\Store;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Advertisement;
use App\Models\Post;
use App\Models\Wallet;
use App\Models\PromotionPackage;
use App\Models\Promotion;
use App\Models\StoreHours;
use App\Models\Like;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Rate;
use App\Models\Block;
use App\Models\Report;
use App\Models\View;
use App\Models\RechargeCode;
use App\Models\RechargeOperation;
use App\Models\SearchLog;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with comprehensive test data
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');

        // Clear existing data (optional - uncomment if needed)
        // $this->command->warn('⚠️  Clearing existing data...');
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // $this->truncateTables();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Create Admins
        $this->command->info('👤 Creating Admins...');
        $admins = Admin::factory()->count(3)->create();
        $this->command->info("✅ Created {$admins->count()} admins");

        // 2. Create Categories
        $this->command->info('📁 Creating Categories...');
        $categories = Category::factory()->count(6)->create();
        $this->command->info("✅ Created {$categories->count()} categories");

        // 3. Create SubCategories
        $this->command->info('📂 Creating SubCategories...');
        $subCategories = collect();
        foreach ($categories as $category) {
            $count = rand(2, 4);
            $subs = SubCategory::factory()->count($count)->create([
                'category_id' => $category->id,
            ]);
            $subCategories = $subCategories->merge($subs);
        }
        $this->command->info("✅ Created {$subCategories->count()} subcategories");

        // 4. Create Users
        $this->command->info('👥 Creating Users...');
        $users = User::factory()->count(20)->create();
        $this->command->info("✅ Created {$users->count()} users");

        // 5. Create Stores
        $this->command->info('🏪 Creating Stores...');
        $stores = collect();
        foreach ($categories as $category) {
            $count = rand(2, 4);
            $categoryStores = Store::factory()->count($count)->create([
                'category_id' => $category->id,
            ]);
            $stores = $stores->merge($categoryStores);
        }
        $this->command->info("✅ Created {$stores->count()} stores");

        // 6. Link SubCategories to Stores
        $this->command->info('🔗 Linking SubCategories to Stores...');
        foreach ($stores as $store) {
            $categorySubCategories = $subCategories->where('category_id', $store->category_id);
            if ($categorySubCategories->isNotEmpty()) {
                $store->subCategories()->attach(
                    $categorySubCategories->random(min(rand(1, 3), $categorySubCategories->count()))->pluck('id')
                );
            }
        }
        $this->command->info('✅ Linked subcategories to stores');

        // 7. Create Traders
        $this->command->info('🧑‍💼 Creating Traders...');
        $traders = collect();
        foreach ($stores as $store) {
            $count = rand(1, 2);
            $storeTraders = Trader::factory()->count($count)->create([
                'store_id' => $store->id,
            ]);
            $traders = $traders->merge($storeTraders);
        }
        $this->command->info("✅ Created {$traders->count()} traders");

        // 8. Create Wallets for Traders
        $this->command->info('💰 Creating Wallets...');
        foreach ($traders as $trader) {
            Wallet::factory()->create([
                'trader_id' => $trader->id,
            ]);
        }
        $this->command->info("✅ Created {$traders->count()} wallets");

        // 9. Create Store Hours
        $this->command->info('🕐 Creating Store Hours...');
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $hoursCount = 0;
        foreach ($stores as $store) {
            foreach ($days as $day) {
                StoreHours::factory()->create([
                    'store_id' => $store->id,
                    'day' => $day,
                    'is_closed' => ($day === 'Friday') ? (rand(0, 100) > 50) : (rand(0, 100) > 90),
                ]);
                $hoursCount++;
            }
        }
        $this->command->info("✅ Created {$hoursCount} store hours");

        // 10. Create Advertisements
        $this->command->info('📢 Creating Advertisements...');
        $advertisements = collect();
        foreach ($traders as $trader) {
            $count = rand(1, 4);
            $traderAds = Advertisement::factory()->count($count)->create([
                'trader_id' => $trader->id,
            ]);
            $advertisements = $advertisements->merge($traderAds);
        }
        $this->command->info("✅ Created {$advertisements->count()} advertisements");

        // 11. Create Posts
        $this->command->info('📝 Creating Posts...');
        $posts = collect();
        foreach ($traders as $trader) {
            $count = rand(1, 3);
            $traderPosts = Post::factory()->count($count)->create([
                'trader_id' => $trader->id,
            ]);
            $posts = $posts->merge($traderPosts);
        }
        $this->command->info("✅ Created {$posts->count()} posts");

        // 12. Create Promotion Packages
        $this->command->info('💎 Creating Promotion Packages...');
        $packages = collect([
            PromotionPackage::factory()->gold()->create(),
            PromotionPackage::factory()->silver()->create(),
            PromotionPackage::factory()->bronze()->create(),
        ]);
        $this->command->info("✅ Created {$packages->count()} promotion packages");

        // 13. Create Promotions
        $this->command->info('⭐ Creating Promotions...');
        $promotions = collect();
        $activeAds = $advertisements->where('status', 'active')->take(15);
        foreach ($activeAds as $ad) {
            if (rand(0, 100) > 60) continue;
            $package = $packages->random();
            $promotion = Promotion::factory()->create([
                'advertisement_id' => $ad->id,
                'package_id' => $package->id,
                'points_paid' => $package->price_points,
            ]);
            $promotions->push($promotion);
        }
        $this->command->info("✅ Created {$promotions->count()} promotions");

        // 14. Create Likes
        $this->command->info('👍 Creating Likes...');
        $likes = collect();
        foreach ($posts as $post) {
            $count = rand(3, min(15, $users->count()));
            // Get unique users for this post to avoid duplicate constraint violations
            $selectedUsers = $users->shuffle()->take($count);
            foreach ($selectedUsers as $user) {
                $like = Like::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
                $likes->push($like);
            }
        }
        $this->command->info("✅ Created {$likes->count()} likes");

        // 15. Create Favorites
        $this->command->info('❤️ Creating Favorites...');
        $favorites = collect();
        $createdFavorites = collect(); // Track created combinations

        // Post favorites
        for ($i = 0; $i < 30; $i++) {
            $userId = $users->random()->id;
            $postId = $posts->random()->id;
            $key = "post-{$userId}-{$postId}";

            if (!$createdFavorites->has($key)) {
                $favorites->push(Favorite::factory()->forPost()->create([
                    'user_id' => $userId,
                    'favorite_id' => $postId,
                ]));
                $createdFavorites->put($key, true);
            }
        }

        // Store favorites
        for ($i = 0; $i < 20; $i++) {
            $userId = $users->random()->id;
            $storeId = $stores->random()->id;
            $key = "store-{$userId}-{$storeId}";

            if (!$createdFavorites->has($key)) {
                $favorites->push(Favorite::factory()->forStore()->create([
                    'user_id' => $userId,
                    'favorite_id' => $storeId,
                ]));
                $createdFavorites->put($key, true);
            }
        }

        // Advertisement favorites
        for ($i = 0; $i < 25; $i++) {
            $userId = $users->random()->id;
            $adId = $advertisements->random()->id;
            $key = "ad-{$userId}-{$adId}";

            if (!$createdFavorites->has($key)) {
                $favorites->push(Favorite::factory()->forAdvertisement()->create([
                    'user_id' => $userId,
                    'favorite_id' => $adId,
                ]));
                $createdFavorites->put($key, true);
            }
        }
        $this->command->info("✅ Created {$favorites->count()} favorites");

        // 16. Create Reviews
        $this->command->info('💬 Creating Reviews...');
        $reviews = collect();
        // Advertisement reviews
        foreach ($advertisements->random(min(25, $advertisements->count())) as $ad) {
            $count = rand(1, min(3, $users->count()));
            $selectedUsers = $users->shuffle()->take($count);
            foreach ($selectedUsers as $user) {
                $reviews->push(Review::factory()->create([
                    'reviewable_id' => $ad->id,
                    'reviewable_type' => Advertisement::class,
                    'user_id' => $user->id,
                ]));
            }
        }
        // Post reviews
        foreach ($posts->random(min(20, $posts->count())) as $post) {
            $count = rand(1, min(2, $users->count()));
            $selectedUsers = $users->shuffle()->take($count);
            foreach ($selectedUsers as $user) {
                $reviews->push(Review::factory()->create([
                    'reviewable_id' => $post->id,
                    'reviewable_type' => Post::class,
                    'user_id' => $user->id,
                ]));
            }
        }
        $this->command->info("✅ Created {$reviews->count()} reviews");

        // 17. Create Rates
        $this->command->info('⭐ Creating Rates...');
        $rates = collect();
        // Advertisement rates
        foreach ($advertisements->random(min(30, $advertisements->count())) as $ad) {
            $count = rand(2, min(5, $users->count()));
            $selectedUsers = $users->shuffle()->take($count);
            foreach ($selectedUsers as $user) {
                $rates->push(Rate::factory()->forAdvertisement()->create([
                    'rated_id' => $ad->id,
                    'user_id' => $user->id,
                ]));
            }
        }
        // Store rates
        foreach ($stores->random(min(15, $stores->count())) as $store) {
            $count = rand(3, min(8, $users->count()));
            $selectedUsers = $users->shuffle()->take($count);
            foreach ($selectedUsers as $user) {
                $rates->push(Rate::factory()->forStore()->create([
                    'rated_id' => $store->id,
                    'user_id' => $user->id,
                ]));
            }
        }
        $this->command->info("✅ Created {$rates->count()} rates");

        // 18. Create Blocks
        $this->command->info('🚫 Creating Blocks...');
        $blocks = collect();
        $createdBlocks = collect(); // Track created combinations

        for ($i = 0; $i < 15; $i++) {
            $userId = $users->random()->id;
            $storeId = $stores->random()->id;
            $key = "store-{$userId}-{$storeId}";

            if (!$createdBlocks->has($key)) {
                $blocks->push(Block::factory()->blockingStore()->create([
                    'user_id' => $userId,
                    'blocked_id' => $storeId,
                ]));
                $createdBlocks->put($key, true);
            }
        }
        $this->command->info("✅ Created {$blocks->count()} blocks");

        // 19. Create Reports
        $this->command->info('🚩 Creating Reports...');
        $reports = collect();
        for ($i = 0; $i < 10; $i++) {
            $reports->push(Report::factory()->create([
                'reportable_id' => $advertisements->random()->id,
                'reportable_type' => Advertisement::class,
                'reporter_id' => $users->random()->id,
                'reporter_type' => User::class,
            ]));
        }
        for ($i = 0; $i < 5; $i++) {
            $reports->push(Report::factory()->create([
                'reportable_id' => $stores->random()->id,
                'reportable_type' => Store::class,
                'reporter_id' => $users->random()->id,
                'reporter_type' => User::class,
            ]));
        }
        $this->command->info("✅ Created {$reports->count()} reports");

        // 20. Create Views
        $this->command->info('👁️ Creating Views...');
        $views = collect();
        foreach ($advertisements as $ad) {
            for ($i = 0; $i < rand(10, 50); $i++) {
                $views->push(View::factory()->forAdvertisement()->create([
                    'viewable_id' => $ad->id,
                    'user_id' => (rand(0, 100) > 40) ? $users->random()->id : null,
                ]));
            }
        }
        foreach ($stores as $store) {
            for ($i = 0; $i < rand(15, 60); $i++) {
                $views->push(View::factory()->forStore()->create([
                    'viewable_id' => $store->id,
                    'user_id' => (rand(0, 100) > 40) ? $users->random()->id : null,
                ]));
            }
        }
        $this->command->info("✅ Created {$views->count()} views");

        // 21. Create Recharge Codes
        $this->command->info('🎫 Creating Recharge Codes...');
        $rechargeCodes = collect();
        // Create unused codes
        $rechargeCodes = $rechargeCodes->merge(RechargeCode::factory()->unused()->count(15)->create());
        // Create used codes
        $rechargeCodes = $rechargeCodes->merge(RechargeCode::factory()->used()->count(10)->create());
        $this->command->info("✅ Created {$rechargeCodes->count()} recharge codes");

        // 22. Create Recharge Operations
        $this->command->info('💳 Creating Recharge Operations...');
        $operations = collect();
        foreach ($traders as $trader) {
            // Create 2-4 operations per trader
            for ($i = 0; $i < rand(2, 4); $i++) {
                // Randomly choose between form_code and from_admin types
                $type = rand(0, 1) === 0 ? 'fromCode' : 'fromAdmin';

                $operations->push(RechargeOperation::factory()->$type()->create([
                    'trader_id' => $trader->id,
                ]));
            }
        }
        $this->command->info("✅ Created {$operations->count()} recharge operations");

        // 23. Create Search Logs
        $this->command->info('🔍 Creating Search Logs...');
        $searchLogs = collect();
        for ($i = 0; $i < 50; $i++) {
            $searchLogs->push(SearchLog::factory()->authenticated()->create([
                'user_id' => $users->random()->id,
            ]));
        }
        for ($i = 0; $i < 30; $i++) {
            $searchLogs->push(SearchLog::factory()->guest()->create());
        }
        $this->command->info("✅ Created {$searchLogs->count()} search logs");

        // Final Summary
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('🎉 Database Seeding Completed Successfully!');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('');
        $this->command->table(
            ['Model', 'Count'],
            [
                ['Admins', $admins->count()],
                ['Users', $users->count()],
                ['Traders', $traders->count()],
                ['Wallets', $traders->count()],
                ['Categories', $categories->count()],
                ['SubCategories', $subCategories->count()],
                ['Stores', $stores->count()],
                ['Store Hours', $hoursCount],
                ['Advertisements', $advertisements->count()],
                ['Posts', $posts->count()],
                ['Promotion Packages', $packages->count()],
                ['Promotions', $promotions->count()],
                ['Likes', $likes->count()],
                ['Favorites', $favorites->count()],
                ['Reviews', $reviews->count()],
                ['Rates', $rates->count()],
                ['Blocks', $blocks->count()],
                ['Reports', $reports->count()],
                ['Views', $views->count()],
                ['Recharge Codes', $rechargeCodes->count()],
                ['Recharge Operations', $operations->count()],
                ['Search Logs', $searchLogs->count()],
            ]
        );
        $this->command->info('');
        $this->command->info('✨ Your database is now populated with realistic test data!');
        $this->command->info('');
    }

    /**
     * Truncate all tables (use with caution)
     */
    protected function truncateTables(): void
    {
        $tables = [
            'search_logs', 'recharge_operations', 'recharge_codes', 'views', 'reports',
            'blocks', 'rates', 'reviews', 'favorites', 'likes', 'promotions',
            'promotion_packages', 'posts', 'advertisements', 'store_hours',
            'sub_categories_stores', 'wallets', 'traders', 'stores',
            'sub_categories', 'categories', 'users', 'admins',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}
