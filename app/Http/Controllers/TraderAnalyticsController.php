<?php

namespace App\Http\Controllers;

use App\Services\TraderAnalyticsService;
use Illuminate\Http\Request;

class TraderAnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(TraderAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Get analytics overview for the authenticated trader
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOverview(Request $request)
    {
        $traderId = $request->user()->id;
        return $this->analyticsService->getOverview($traderId);
    }

    /**
     * Get analytics for each advertisement
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdsAnalytics(Request $request)
    {
        $traderId = $request->user()->id;
        return $this->analyticsService->getAdsAnalytics($traderId);
    }

    /**
     * Get chart data for a specific period
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChartData(Request $request)
    {
        $traderId = $request->user()->id;
        $period = $request->query('period', 'week');
        return $this->analyticsService->getChartData($traderId, $period);
    }
}
