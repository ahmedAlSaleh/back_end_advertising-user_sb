<?php

namespace App\Services;

use App\Models\Store;
use App\Models\StoreHours;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreHoursService
{
    use ApiResponse;

    /**
     * Get store hours for a trader's store
     */
    public function getStoreHours($traderId)
    {
        try {
            $trader = \App\Models\Trader::findOrFail($traderId);
            $storeId = $trader->store_id;

            if (!$storeId) {
                return $this->error('Trader has no associated store', 404);
            }

            $hours = StoreHours::where('store_id', $storeId)
                ->orderByRaw("FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')")
                ->get();

            return $this->success([
                'hours' => $hours,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching store hours: ' . $e->getMessage());
            return $this->error('Failed to fetch store hours', 500);
        }
    }

    /**
     * Create or update store hours for a trader's store
     */
    public function updateStoreHours($traderId, $hoursData)
    {
        try {
            return DB::transaction(function () use ($traderId, $hoursData) {
                $trader = \App\Models\Trader::findOrFail($traderId);
                $storeId = $trader->store_id;

                if (!$storeId) {
                    return $this->error('Trader has no associated store', 404);
                }

                // Validate and process each day
                foreach ($hoursData as $hourEntry) {
                    // Normalize day name to match enum (capitalize first letter)
                    $day = ucfirst(strtolower($hourEntry['day']));

                    // Validate day
                    if (!in_array($day, ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])) {
                        return $this->error("Invalid day: {$hourEntry['day']}", 400);
                    }

                    // If is_closed is true, set opens_at and closes_at to null
                    if ($hourEntry['is_closed'] ?? false) {
                        $opensAt = null;
                        $closesAt = null;
                    } else {
                        $opensAt = $hourEntry['opens_at'] ?? null;
                        $closesAt = $hourEntry['closes_at'] ?? null;

                        // Validate time format if provided
                        if ($opensAt && !$this->isValidTime($opensAt)) {
                            return $this->error("Invalid opens_at time format for {$day}", 400);
                        }
                        if ($closesAt && !$this->isValidTime($closesAt)) {
                            return $this->error("Invalid closes_at time format for {$day}", 400);
                        }
                    }

                    // Update or create the store hours
                    StoreHours::updateOrCreate(
                        [
                            'store_id' => $storeId,
                            'day' => $day,
                        ],
                        [
                            'opens_at' => $opensAt,
                            'closes_at' => $closesAt,
                            'is_closed' => $hourEntry['is_closed'] ?? false,
                        ]
                    );
                }

                // Fetch updated hours
                $updatedHours = StoreHours::where('store_id', $storeId)
                    ->orderByRaw("FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')")
                    ->get();

                return $this->success([
                    'hours' => $updatedHours,
                    'message' => 'Store hours updated successfully',
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error updating store hours: ' . $e->getMessage());
            return $this->error('Failed to update store hours', 500);
        }
    }

    /**
     * Get formatted store hours for display
     */
    public function getFormattedStoreHours($storeId)
    {
        $hours = StoreHours::where('store_id', $storeId)
            ->orderByRaw("FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')")
            ->get();

        return $hours->map(function ($hour) {
            return [
                'day' => strtolower($hour->day),
                'day_name' => $hour->day,
                'opens_at' => $hour->opens_at,
                'closes_at' => $hour->closes_at,
                'is_closed' => $hour->is_closed,
            ];
        });
    }

    /**
     * Check if store is currently open
     */
    public function isStoreOpenNow($storeId)
    {
        $now = Carbon::now();
        $currentDay = $now->format('l'); // e.g., "Monday"
        $currentTime = $now->format('H:i:s');

        $todayHours = StoreHours::where('store_id', $storeId)
            ->where('day', $currentDay)
            ->first();

        if (!$todayHours) {
            return false;
        }

        if ($todayHours->is_closed) {
            return false;
        }

        if (!$todayHours->opens_at || !$todayHours->closes_at) {
            return false;
        }

        // Check if current time is between opens_at and closes_at
        return $currentTime >= $todayHours->opens_at && $currentTime <= $todayHours->closes_at;
    }

    /**
     * Get next opening time
     */
    public function getNextOpening($storeId)
    {
        $now = Carbon::now();
        $currentDay = $now->format('l');
        $currentTime = $now->format('H:i:s');

        // Get all store hours ordered by day
        $allHours = StoreHours::where('store_id', $storeId)
            ->orderByRaw("FIELD(day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')")
            ->get();

        if ($allHours->isEmpty()) {
            return null;
        }

        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $currentDayIndex = array_search($currentDay, $daysOfWeek);

        // Check if store opens later today
        $todayHours = $allHours->where('day', $currentDay)->first();
        if ($todayHours && !$todayHours->is_closed && $todayHours->opens_at && $currentTime < $todayHours->opens_at) {
            return "Today at " . Carbon::parse($todayHours->opens_at)->format('g:i A');
        }

        // Check next 7 days
        for ($i = 1; $i <= 7; $i++) {
            $nextDayIndex = ($currentDayIndex + $i) % 7;
            $nextDay = $daysOfWeek[$nextDayIndex];

            $nextDayHours = $allHours->where('day', $nextDay)->first();

            if ($nextDayHours && !$nextDayHours->is_closed && $nextDayHours->opens_at) {
                if ($i == 1) {
                    return "Tomorrow at " . Carbon::parse($nextDayHours->opens_at)->format('g:i A');
                } else {
                    return $nextDay . " at " . Carbon::parse($nextDayHours->opens_at)->format('g:i A');
                }
            }
        }

        return null;
    }

    /**
     * Validate time format (HH:MM or HH:MM:SS)
     */
    private function isValidTime($time)
    {
        return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $time);
    }
}
