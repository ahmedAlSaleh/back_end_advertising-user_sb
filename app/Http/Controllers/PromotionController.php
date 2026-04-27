<?php

namespace App\Http\Controllers;

use App\Services\PromotionService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    /**
     * Get all available promotion packages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPackages()
    {
        return $this->promotionService->getPackages();
    }

    /**
     * Promote an advertisement (Trader only)
     *
     * @param Request $request
     * @param int $advertisementId
     * @return \Illuminate\Http\JsonResponse
     */
    public function promoteAd(Request $request, $advertisementId)
    {
        $request->validate([
            'package_id' => 'required|integer|exists:promotion_packages,id',
        ]);

        $traderId = $request->user()->id;
        $packageId = $request->input('package_id');

        return $this->promotionService->promoteAdvertisement($advertisementId, $packageId, $traderId);
    }

    /**
     * Get all featured advertisements
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFeaturedAds(Request $request)
    {
        return $this->promotionService->getFeaturedAds($request);
    }
}
