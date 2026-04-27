<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvancedSearchRequest;
use App\Services\SearchService;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Advanced search for advertisements
     *
     * @param AdvancedSearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function advancedSearch(AdvancedSearchRequest $request)
    {
        return $this->searchService->advancedSearch($request);
    }
}
