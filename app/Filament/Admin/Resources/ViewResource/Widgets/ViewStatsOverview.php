<?php

namespace App\Filament\Admin\Resources\ViewResource\Widgets;

use App\Models\View;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ViewStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Views', View::count())
                ->description('All time views')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),

            Stat::make('Views Today', View::whereDate('created_at', today())->count())
                ->description('Views recorded today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('Views This Week', View::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->description('Last 7 days')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),

            Stat::make('Unique Visitors', View::distinct('ip_address')->count('ip_address'))
                ->description('Unique IP addresses')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
