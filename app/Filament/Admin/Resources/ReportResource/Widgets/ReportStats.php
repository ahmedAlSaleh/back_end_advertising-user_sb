<?php

namespace App\Filament\Admin\Resources\ReportResource\Widgets;

use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Reports', Report::where('status', 'pending')->count())
                ->description('Awaiting review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total Reports', Report::count())
                ->description('All time')
                ->descriptionIcon('heroicon-m-flag')
                ->color('primary'),

            Stat::make('Reports Today', Report::whereDate('created_at', today())->count())
                ->description('Submitted today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            Stat::make('Resolved This Week', Report::where('status', 'resolved')
                ->whereBetween('resolved_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count())
                ->description('Last 7 days')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
