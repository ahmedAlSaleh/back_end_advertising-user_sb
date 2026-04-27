<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Create a new report
     *
     * @param ReportRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReportRequest $request)
    {
        return $this->reportService->createReport($request);
    }

    /**
     * Get available report reasons
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReasons()
    {
        return $this->reportService->getReasons();
    }

    /**
     * Get authenticated user's reports
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserReports(Request $request)
    {
        return $this->reportService->getUserReports($request);
    }
}
