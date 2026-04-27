<?php

namespace App\Services;

use App\Models\View;
use App\Models\Advertisement;
use App\Models\Favorite;
use App\Models\Rate;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class TraderAnalyticsService
{
    use ApiResponse;

    /**
     * Get overview analytics for the trader
     */
    public function getOverview($traderId)
    {
        try {
            // Get trader's advertisements
            $advertisements = Advertisement::where('trader_id', $traderId)->pluck('id');

            // Total views (for all trader's ads)
            $totalViews = View::where('viewable_type', 'advertisement')
                ->whereIn('viewable_id', $advertisements)
                ->count();

            // Total favorites
            $totalFavorites = Favorite::where('favorite_type', 'advertisement')
                ->whereIn('favorite_id', $advertisements)
                ->count();

            // Total ads
            $totalAds = $advertisements->count();

            // Average rating
            $averageRating = Rate::where('rated_type', 'trader')
                ->where('rated_id', $traderId)
                ->avg('rate') ?? 0;

            // Views this week
            $viewsThisWeek = View::where('viewable_type', 'advertisement')
                ->whereIn('viewable_id', $advertisements)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();

            // Views last week
            $viewsLastWeek = View::where('viewable_type', 'advertisement')
                ->whereIn('viewable_id', $advertisements)
                ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
                ->count();

            // Growth percentage
            $growthPercentage = 0;
            if ($viewsLastWeek > 0) {
                $growthPercentage = (($viewsThisWeek - $viewsLastWeek) / $viewsLastWeek) * 100;
            }

            return $this->success([
                'total_views' => $totalViews,
                'total_favorites' => $totalFavorites,
                'total_ads' => $totalAds,
                'average_rating' => round($averageRating, 2),
                'views_this_week' => $viewsThisWeek,
                'views_last_week' => $viewsLastWeek,
                'growth_percentage' => round($growthPercentage, 1),
            ], 'Analytics overview retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve analytics overview: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get statistics for each advertisement
     */
    public function getAdsAnalytics($traderId)
    {
        try {
            $ads = Advertisement::where('trader_id', $traderId)
                ->select('id', 'title')
                ->get()
                ->map(function ($ad) {
                    // Count views for this ad
                    $views = View::where('viewable_type', 'advertisement')
                        ->where('viewable_id', $ad->id)
                        ->count();

                    // Count favorites for this ad
                    $favorites = Favorite::where('favorite_type', 'advertisement')
                        ->where('favorite_id', $ad->id)
                        ->count();

                    return [
                        'id' => $ad->id,
                        'title' => $ad->title,
                        'views' => $views,
                        'favorites' => $favorites,
                    ];
                });

            return $this->success([
                'ads' => $ads,
            ], 'Advertisement analytics retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve ads analytics: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get chart data for a specific period
     */
    public function getChartData($traderId, $period = 'week')
    {
        try {
            // Get trader's advertisements
            $advertisements = Advertisement::where('trader_id', $traderId)->pluck('id');

            $labels = [];
            $viewsData = [];
            $favoritesData = [];

            switch ($period) {
                case 'week':
                    // Last 7 days
                    for ($i = 6; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $labels[] = $date->format('l'); // Day name (Monday, Tuesday, etc.)

                        // Count views for this day
                        $views = View::where('viewable_type', 'advertisement')
                            ->whereIn('viewable_id', $advertisements)
                            ->whereDate('created_at', $date->toDateString())
                            ->count();
                        $viewsData[] = $views;

                        // Count favorites for this day
                        $favorites = Favorite::where('favorite_type', 'advertisement')
                            ->whereIn('favorite_id', $advertisements)
                            ->whereDate('created_at', $date->toDateString())
                            ->count();
                        $favoritesData[] = $favorites;
                    }
                    break;

                case 'month':
                    // Last 30 days
                    for ($i = 29; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $labels[] = $date->format('M d'); // Month Day (Jan 01, Jan 02, etc.)

                        // Count views for this day
                        $views = View::where('viewable_type', 'advertisement')
                            ->whereIn('viewable_id', $advertisements)
                            ->whereDate('created_at', $date->toDateString())
                            ->count();
                        $viewsData[] = $views;

                        // Count favorites for this day
                        $favorites = Favorite::where('favorite_type', 'advertisement')
                            ->whereIn('favorite_id', $advertisements)
                            ->whereDate('created_at', $date->toDateString())
                            ->count();
                        $favoritesData[] = $favorites;
                    }
                    break;

                case 'year':
                    // Last 12 months
                    for ($i = 11; $i >= 0; $i--) {
                        $date = now()->subMonths($i);
                        $labels[] = $date->format('M Y'); // Month Year (Jan 2024, Feb 2024, etc.)

                        // Count views for this month
                        $views = View::where('viewable_type', 'advertisement')
                            ->whereIn('viewable_id', $advertisements)
                            ->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count();
                        $viewsData[] = $views;

                        // Count favorites for this month
                        $favorites = Favorite::where('favorite_type', 'advertisement')
                            ->whereIn('favorite_id', $advertisements)
                            ->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count();
                        $favoritesData[] = $favorites;
                    }
                    break;

                default:
                    return $this->error('Invalid period. Use: week, month, or year', 400);
            }

            return $this->success([
                'labels' => $labels,
                'views' => $viewsData,
                'favorites' => $favoritesData,
            ], 'Chart data retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve chart data: ' . $e->getMessage(), 500);
        }
    }
}
