<?php

namespace App\Jobs;

use App\Services\PromotionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExpirePromotions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(PromotionService $promotionService): void
    {
        try {
            $expiredCount = $promotionService->expireOldPromotions();
            Log::info("Expired {$expiredCount} promotions successfully");
        } catch (\Exception $e) {
            Log::error('Failed to expire promotions: ' . $e->getMessage());
        }
    }
}
