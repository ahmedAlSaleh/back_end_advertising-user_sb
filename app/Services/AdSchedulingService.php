<?php

namespace App\Services;

use App\Models\Advertisement;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdSchedulingService
{
    use ApiResponse;

    /**
     * Update advertisement status
     */
    public function updateStatus($advertisementId, $status, $traderId)
    {
        try {
            $advertisement = Advertisement::where('id', $advertisementId)
                ->where('trader_id', $traderId)
                ->firstOrFail();

            // Validate status transition
            $validStatuses = ['draft', 'scheduled', 'active', 'expired', 'paused'];
            if (!in_array($status, $validStatuses)) {
                return $this->error('Invalid status value', 400);
            }

            // Prevent manual activation of scheduled ads
            if ($status === 'active' && $advertisement->scheduled_at && now()->lt($advertisement->scheduled_at)) {
                return $this->error('Cannot activate ad before scheduled time', 400);
            }

            $advertisement->status = $status;
            $advertisement->save();

            return $this->success([
                'advertisement' => $advertisement,
                'message' => 'Advertisement status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating advertisement status: ' . $e->getMessage());
            return $this->error('Failed to update advertisement status', 500);
        }
    }

    /**
     * Get scheduled advertisements for a trader
     */
    public function getScheduledAds($traderId)
    {
        try {
            $scheduledAds = Advertisement::with(['image', 'trader.store'])
                ->where('trader_id', $traderId)
                ->where('status', 'scheduled')
                ->orderBy('scheduled_at', 'asc')
                ->paginate(10);

            return $this->success([
                'scheduled_ads' => $scheduledAds,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching scheduled ads: ' . $e->getMessage());
            return $this->error('Failed to fetch scheduled ads', 500);
        }
    }

    /**
     * Get expired advertisements for a trader
     */
    public function getExpiredAds($traderId)
    {
        try {
            $expiredAds = Advertisement::with(['image', 'trader.store'])
                ->where('trader_id', $traderId)
                ->where('status', 'expired')
                ->orderBy('expires_at', 'desc')
                ->paginate(10);

            return $this->success([
                'expired_ads' => $expiredAds,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching expired ads: ' . $e->getMessage());
            return $this->error('Failed to fetch expired ads', 500);
        }
    }

    /**
     * Renew an expired advertisement
     */
    public function renewAdvertisement($advertisementId, $traderId, $expiresAt = null)
    {
        try {
            return DB::transaction(function () use ($advertisementId, $traderId, $expiresAt) {
                $advertisement = Advertisement::where('id', $advertisementId)
                    ->where('trader_id', $traderId)
                    ->where('status', 'expired')
                    ->firstOrFail();

                // Set new expiration date (default: 30 days from now)
                $newExpiresAt = $expiresAt ? $expiresAt : now()->addDays(30);

                $advertisement->expires_at = $newExpiresAt;
                $advertisement->status = 'active';
                $advertisement->save();

                return $this->success([
                    'advertisement' => $advertisement,
                    'message' => 'Advertisement renewed successfully'
                ]);
            });
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Advertisement not found or cannot be renewed', 404);
        } catch (\Exception $e) {
            Log::error('Error renewing advertisement: ' . $e->getMessage());
            return $this->error('Failed to renew advertisement', 500);
        }
    }

    /**
     * Process scheduled advertisements (called by job)
     * Activates scheduled ads that are due and expires ads that are past their expiration
     */
    public function processScheduledAds()
    {
        try {
            $activatedCount = 0;
            $expiredCount = 0;

            // Activate scheduled ads that are due
            $adsToActivate = Advertisement::where('status', 'scheduled')
                ->where('scheduled_at', '<=', now())
                ->get();

            foreach ($adsToActivate as $ad) {
                $ad->status = 'active';
                $ad->save();
                $activatedCount++;
            }

            // Expire active ads that are past their expiration date
            $adsToExpire = Advertisement::where('status', 'active')
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', now())
                ->get();

            foreach ($adsToExpire as $ad) {
                $ad->status = 'expired';
                $ad->save();
                $expiredCount++;
            }

            Log::info("Processed scheduled ads: {$activatedCount} activated, {$expiredCount} expired");

            return [
                'activated' => $activatedCount,
                'expired' => $expiredCount
            ];
        } catch (\Exception $e) {
            Log::error('Error processing scheduled ads: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Validate scheduling dates
     */
    public function validateSchedulingDates($scheduledAt, $expiresAt)
    {
        if ($scheduledAt && $expiresAt) {
            if (strtotime($scheduledAt) >= strtotime($expiresAt)) {
                return [
                    'valid' => false,
                    'message' => 'Expiration date must be after scheduled date'
                ];
            }
        }

        if ($scheduledAt && strtotime($scheduledAt) < time()) {
            return [
                'valid' => false,
                'message' => 'Scheduled date must be in the future'
            ];
        }

        return ['valid' => true];
    }

    /**
     * Determine initial status based on scheduling dates
     */
    public function determineInitialStatus($scheduledAt, $expiresAt)
    {
        if ($scheduledAt && strtotime($scheduledAt) > time()) {
            return 'scheduled';
        }

        if ($expiresAt && strtotime($expiresAt) < time()) {
            return 'expired';
        }

        return 'active';
    }
}
