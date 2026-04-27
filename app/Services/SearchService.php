<?php

namespace App\Services;

use App\Models\Advertisement;
use App\Models\SearchLog;
use App\Models\Store;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchService
{
    use ApiResponse;

    public function advancedSearch($request)
    {
        // Start building the query - only show active ads
        $query = Advertisement::with(['image', 'trader.store', 'rates'])
            ->where('status', 'active');

        // Apply keyword filter
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%")
                  ->orWhere('notes', 'LIKE', "%{$keyword}%");
            });
        }

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->whereHas('trader.store', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Apply subcategory filter
        if ($request->filled('sub_category_id')) {
            $query->whereHas('trader.store.subCategories', function ($q) use ($request) {
                $q->where('sub_categories.id', $request->sub_category_id);
            });
        }

        // Apply city filter
        if ($request->filled('city')) {
            $query->whereHas('trader', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        // Apply price range filter
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Apply rating filter
        if ($request->filled('rating_min')) {
            $query->whereHas('rates', function ($q) use ($request) {
                $q->select('rated_id')
                  ->groupBy('rated_id')
                  ->havingRaw('AVG(rate) >= ?', [$request->rating_min]);
            });
        }

        // Apply sorting - Featured ads first, then by user's preference
        $sortBy = $request->input('sort_by', 'newest');
        $sortOrder = $request->input('sort_order', 'desc');

        // Always prioritize featured ads
        $query->orderByRaw('CASE WHEN is_featured = 1 AND featured_until > NOW() THEN 0 ELSE 1 END')
              ->orderByRaw('CASE WHEN feature_type = "premium" THEN 0 WHEN feature_type = "basic" THEN 1 ELSE 2 END');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'rating':
                $query->withAvg('rates as average_rating', 'rate')
                      ->orderBy('average_rating', $sortOrder);
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', $sortOrder);
                break;
        }

        // Get total count before pagination
        $totalResults = $query->count();

        // Paginate results
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);
        $advertisements = $query->paginate($perPage, ['*'], 'page', $page);

        // Add average rating to each advertisement
        $advertisements->getCollection()->transform(function ($ad) {
            $ad->average_rating = $ad->rates->avg('rate') ?? 0;
            $ad->total_ratings = $ad->rates->count();
            return $ad;
        });

        // Log the search
        $this->logSearch($request, $totalResults);

        // Prepare filters applied
        $filtersApplied = $this->getAppliedFilters($request);

        // Return response
        return $this->success([
            'advertisements' => $advertisements->items(),
            'pagination' => [
                'current_page' => $advertisements->currentPage(),
                'per_page' => $advertisements->perPage(),
                'total' => $advertisements->total(),
                'last_page' => $advertisements->lastPage(),
                'from' => $advertisements->firstItem(),
                'to' => $advertisements->lastItem(),
            ],
            'total_results' => $totalResults,
            'filters_applied' => $filtersApplied,
        ], 'Search completed successfully');
    }

    protected function logSearch($request, $resultsCount)
    {
        SearchLog::create([
            'keyword' => $request->keyword,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'city' => $request->city,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'rating_min' => $request->rating_min,
            'sort_by' => $request->sort_by,
            'sort_order' => $request->sort_order,
            'results_count' => $resultsCount,
            'user_ip' => $request->ip(),
            'user_id' => Auth::id(),
        ]);
    }

    protected function getAppliedFilters($request)
    {
        $filters = [];

        if ($request->filled('keyword')) {
            $filters['keyword'] = $request->keyword;
        }

        if ($request->filled('category_id')) {
            $filters['category_id'] = $request->category_id;
        }

        if ($request->filled('sub_category_id')) {
            $filters['sub_category_id'] = $request->sub_category_id;
        }

        if ($request->filled('city')) {
            $filters['city'] = $request->city;
        }

        if ($request->filled('price_min') || $request->filled('price_max')) {
            $filters['price_range'] = [
                'min' => $request->price_min,
                'max' => $request->price_max,
            ];
        }

        if ($request->filled('rating_min')) {
            $filters['rating_min'] = $request->rating_min;
        }

        if ($request->filled('sort_by')) {
            $filters['sort_by'] = $request->sort_by;
            $filters['sort_order'] = $request->sort_order ?? 'desc';
        }

        return $filters;
    }
}
