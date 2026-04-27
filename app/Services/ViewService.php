<?php

namespace App\Services;

use App\Models\View;
use Illuminate\Http\Request;

class ViewService
{
    /**
     * Record a view for any viewable model (advertisement, store, post)
     *
     * @param string $viewableType - Type of model: 'advertisement', 'store', 'post'
     * @param int $viewableId - ID of the model
     * @param Request|null $request - HTTP request object to extract IP and user agent
     * @return void
     */
    public function recordView(string $viewableType, int $viewableId, ?Request $request = null)
    {
        try {
            $data = [
                'viewable_type' => $viewableType,
                'viewable_id' => $viewableId,
            ];

            // Get user ID if authenticated
            if ($request && $request->user()) {
                $data['user_id'] = $request->user()->id;
            }

            // Get IP address
            if ($request) {
                $data['ip_address'] = $request->ip();
                $data['user_agent'] = $request->userAgent();
            }

            // Create the view record
            View::create($data);
        } catch (\Exception $e) {
            // Log error but don't stop execution
            \Log::error('Failed to record view: ' . $e->getMessage());
        }
    }

    /**
     * Get total views for a viewable model
     *
     * @param string $viewableType
     * @param int $viewableId
     * @return int
     */
    public function getViewCount(string $viewableType, int $viewableId): int
    {
        return View::where('viewable_type', $viewableType)
            ->where('viewable_id', $viewableId)
            ->count();
    }

    /**
     * Get unique views (by IP) for a viewable model
     *
     * @param string $viewableType
     * @param int $viewableId
     * @return int
     */
    public function getUniqueViewCount(string $viewableType, int $viewableId): int
    {
        return View::where('viewable_type', $viewableType)
            ->where('viewable_id', $viewableId)
            ->distinct('ip_address')
            ->count('ip_address');
    }
}
