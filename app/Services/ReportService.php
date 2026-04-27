<?php

namespace App\Services;

use App\Models\Report;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class ReportService
{
    use ApiResponse;

    /**
     * Create a new report
     */
    public function createReport($request)
    {
        try {
            // Get authenticated user
            $user = Auth::user();

            // Determine reporter type (user or trader)
            $reporterType = $user instanceof \App\Models\Trader ? 'trader' : 'user';

            // Create the report
            $report = Report::create([
                'reporter_id' => $user->id,
                'reporter_type' => $reporterType,
                'reportable_id' => $request->reportable_id,
                'reportable_type' => $request->reportable_type,
                'reason' => $request->reason,
                'description' => $request->description,
                'status' => 'pending',
            ]);

            return $this->success([
                'report' => $report,
            ], 'Report submitted successfully. We will review it shortly.');
        } catch (\Exception $e) {
            return $this->error('Failed to submit report: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get report reasons with labels
     */
    public function getReasons()
    {
        try {
            $reasons = Report::getReasonLabels();

            // Format for API response
            $formatted = [];
            foreach ($reasons as $key => $label) {
                $formatted[] = [
                    'value' => $key,
                    'label' => $label,
                ];
            }

            return $this->success([
                'reasons' => $formatted,
            ], 'Report reasons retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve reasons: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get user's reports
     */
    public function getUserReports($request)
    {
        try {
            $user = Auth::user();
            $reporterType = $user instanceof \App\Models\Trader ? 'trader' : 'user';

            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            $reports = Report::where('reporter_id', $user->id)
                ->where('reporter_type', $reporterType)
                ->with('reportable')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            // Add reason and status labels
            $reports->getCollection()->each(function ($report) {
                $report->reason_label = Report::getReasonLabels()[$report->reason] ?? $report->reason;
                $report->status_label = Report::getStatusLabels()[$report->status] ?? $report->status;
            });

            return $this->success([
                'reports' => $reports,
            ], 'User reports retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve reports: ' . $e->getMessage(), 500);
        }
    }
}
