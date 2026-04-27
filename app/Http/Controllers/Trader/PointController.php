<?php

namespace App\Http\Controllers\Trader;

use App\Http\Controllers\Controller;
use App\Http\Requests\RechargePointRequest;
use App\Services\AdsService;
use App\Services\PointService;
use Illuminate\Http\Request;

class PointController extends Controller
{
    protected  $pointservise;

    public function __construct(PointService $pointService)
    {
        $this->pointservise = $pointService;
    }
    public function getPoint() {
        $res = $this->pointservise->getPoint();
        return $res;
    }
        public function getWallet() {
        $res = $this->pointservise->getWallet();
        return $res;
    }

    public function rechargePoint(RechargePointRequest $request) {
        $res = $this->pointservise->rechargePoint($request);
        return $res;
    }
}
