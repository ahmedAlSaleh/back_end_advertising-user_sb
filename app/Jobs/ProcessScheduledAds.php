<?php

namespace App\Jobs;

use App\Services\AdSchedulingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessScheduledAds implements ShouldQueue
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
    public function handle(AdSchedulingService $schedulingService): void
    {
        try {
            $result = $schedulingService->processScheduledAds();
            Log::info('ProcessScheduledAds job completed', $result);
        } catch (\Exception $e) {
            Log::error('ProcessScheduledAds job failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
