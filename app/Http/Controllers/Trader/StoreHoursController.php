<?php

namespace App\Http\Controllers\Trader;

use App\Http\Controllers\Controller;
use App\Services\StoreHoursService;
use Illuminate\Http\Request;

class StoreHoursController extends Controller
{
    protected $storeHoursService;

    public function __construct(StoreHoursService $storeHoursService)
    {
        $this->storeHoursService = $storeHoursService;
    }

    /**
     * Get store hours for authenticated trader
     */
    public function getHours(Request $request)
    {
        $traderId = $request->user()->id;
        return $this->storeHoursService->getStoreHours($traderId);
    }

    /**
     * Create or update store hours
     */
    public function updateHours(Request $request)
    {
        $request->validate([
            'hours' => 'required|array',
            'hours.*.day' => 'required|string',
            'hours.*.opens_at' => 'nullable|string',
            'hours.*.closes_at' => 'nullable|string',
            'hours.*.is_closed' => 'boolean',
        ]);

        $traderId = $request->user()->id;
        return $this->storeHoursService->updateStoreHours($traderId, $request->hours);
    }
}
