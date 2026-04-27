<?php

namespace App\Filament\Admin\Resources\SearchLogResource\Widgets;

use App\Models\SearchLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SearchStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Searches', SearchLog::count())
                ->description('All time')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('success'),

            Stat::make('Searches Today', SearchLog::whereDate('created_at', today())->count())
                ->description('Searches performed today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('Searches This Week', SearchLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->description('Last 7 days')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),

            Stat::make('Average Results', number_format(SearchLog::avg('results_count') ?? 0, 2))
                ->description('Average search results per query')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->color('info'),
        ];
    }
}
