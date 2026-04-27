<?php

namespace App\Services;

use App\Models\Advertisement;
use App\Models\Promotion;
use App\Models\PromotionPackage;
use App\Models\Wallet;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class PromotionService
{
    use ApiResponse;

    /**
     * Get all active promotion packages
     */
    public function getPackages()
    {
        try {
            $packages = PromotionPackage::where('is_active', true)
                ->orderBy('price_points', 'asc')
                ->get();

            return $this->success([
                'packages' => $packages,
            ], 'Promotion packages retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve packages: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Promote an advertisement
     */
    public function promoteAdvertisement($advertisementId, $packageId, $traderId)
    {
        try {
            return DB::transaction(function () use ($advertisementId, $packageId, $traderId) {
                // 1. Verify advertisement belongs to trader
                $advertisement = Advertisement::where('id', $advertisementId)
                    ->where('trader_id', $traderId)
                    ->firstOrFail();

                // 2. Get the package
                $package = PromotionPackage::where('id', $packageId)
                    ->where('is_active', true)
                    ->firstOrFail();

                // 3. Get trader's wallet
                $wallet = Wallet::where('trader_id', $traderId)->firstOrFail();

                // 4. Check if trader has enough points
                if ($wallet->current_balance < $package->price_points) {
                    return $this->error('Insufficient points. You need ' . $package->price_points . ' points.', 400);
                }

                // 5. Check if ad is already promoted
                $existingPromotion = Promotion::where('advertisement_id', $advertisementId)
                    ->where('expires_at', '>', now())
                    ->first();

                if ($existingPromotion) {
                    return $this->error('Advertisement is already promoted until ' . $existingPromotion->expires_at->format('Y-m-d H:i:s'), 400);
                }

                // 6. Deduct points from wallet
                $wallet->current_balance -= $package->price_points;
                $wallet->save();

                // 7. Calculate dates
                $startedAt = now();
                $expiresAt = now()->addDays($package->duration_days);

                // 8. Create promotion record
                $promotion = Promotion::create([
                    'advertisement_id' => $advertisementId,
                    'package_id' => $packageId,
                    'started_at' => $startedAt,
                    'expires_at' => $expiresAt,
                    'points_paid' => $package->price_points,
                ]);

                // 9. Update advertisement featured status
                $advertisement->is_featured = true;
                $advertisement->featured_until = $expiresAt;
                $advertisement->feature_type = $this->getFeatureType($package->name);
                $advertisement->save();

                return $this->success([
                    'promotion' => $promotion->load('package'),
                    'advertisement' => $advertisement,
                    'remaining_balance' => $wallet->current_balance,
                ], 'Advertisement promoted successfully');
            });
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Advertisement, package, or wallet not found', 404);
        } catch (\Exception $e) {
            return $this->error('Failed to promote advertisement: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get featured advertisements only
     */
    public function getFeaturedAds($request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            $ads = Advertisement::with(['image', 'trader.store'])
                ->where('is_featured', true)
                ->where('featured_until', '>', now())
                ->orderBy('feature_type', 'desc') // premium first, then basic
                ->orderBy('featured_until', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            // Add is_featured flag to response
            $ads->getCollection()->each(function ($ad) {
                $ad->is_featured_tag = true;
                $ad->city = $ad->trader->city ?? null;
                $ad->makeHidden(['trader']);
            });

            return $this->success([
                'ads' => $ads,
            ], 'Featured advertisements retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve featured ads: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Map package name to feature type
     */
    private function getFeatureType($packageName): string
    {
        return match (strtolower($packageName)) {
            'premium', 'vip' => 'premium',
            'basic' => 'basic',
            default => 'basic',
        };
    }

    /**
     * Expire old promotions (called by scheduled job)
     */
    public function expireOldPromotions()
    {
        try {
            // Find all advertisements with expired featured status
            $expiredAds = Advertisement::where('is_featured', true)
                ->where('featured_until', '<=', now())
                ->get();

            foreach ($expiredAds as $ad) {
                $ad->is_featured = false;
                $ad->featured_until = null;
                $ad->feature_type = 'none';
                $ad->save();
            }

            return $expiredAds->count();
        } catch (\Exception $e) {
            \Log::error('Failed to expire promotions: ' . $e->getMessage());
            return 0;
        }
    }
}
