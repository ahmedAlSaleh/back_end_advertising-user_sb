<?php
namespace App\Http\Controllers\Trader;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdsRequest;


use App\Services\AdsService;
use App\Services\AdSchedulingService;
use Illuminate\Http\Request;


class AdsController extends Controller {

    protected  $adsservise;
    protected  $schedulingService;

    public function __construct(AdsService $adsService, AdSchedulingService $schedulingService)
    {
        $this->adsservise = $adsService;
        $this->schedulingService = $schedulingService;
    }

    public function create_ads(AdsRequest $request)
    {
        $res = $this->adsservise->create_ads($request);
        return $res ;
    }
    public function get_my_ads(Request $request)
    {
        $res = $this->adsservise->get_my_ads($request);
        return $res ;
    }
    public function delete_ads($request)
    {
        $res = $this->adsservise->delete_ads($request);
        return $res ;
    }

    /**
     * Update advertisement status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:draft,scheduled,active,expired,paused'
        ]);

        $traderId = $request->user()->id;
        return $this->schedulingService->updateStatus($id, $request->status, $traderId);
    }

    /**
     * Get scheduled advertisements
     */
    public function getScheduled(Request $request)
    {
        $traderId = $request->user()->id;
        return $this->schedulingService->getScheduledAds($traderId);
    }

    /**
     * Get expired advertisements
     */
    public function getExpired(Request $request)
    {
        $traderId = $request->user()->id;
        return $this->schedulingService->getExpiredAds($traderId);
    }

    /**
     * Renew expired advertisement
     */
    public function renew(Request $request, $id)
    {
        $request->validate([
            'expires_at' => 'nullable|date|after:now'
        ]);

        $traderId = $request->user()->id;
        $expiresAt = $request->expires_at ?? null;
        return $this->schedulingService->renewAdvertisement($id, $traderId, $expiresAt);
    }
}

