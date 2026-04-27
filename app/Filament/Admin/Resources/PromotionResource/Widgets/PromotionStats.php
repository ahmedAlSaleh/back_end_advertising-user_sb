<?php

namespace App\Filament\Admin\Resources\PromotionResource\Widgets;

use App\Models\Promotion;
use App\Models\Advertisement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PromotionStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Active Promotions', Promotion::where('expires_at', '>', now())->count())
                ->description('Currently running')
                ->descriptionIcon('heroicon-m-rocket-launch')
                ->color('success'),

            Stat::make('Total Revenue', number_format(Promotion::sum('points_paid'), 2) . ' pts')
                ->description('All time points collected')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),

            Stat::make('Promoted This Week', Promotion::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->description('Last 7 days')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),

            Stat::make('Featured Ads', Advertisement::where('is_featured', true)->where('featured_until', '>', now())->count())
                ->description('Currently featured advertisements')
                ->descriptionIcon('heroicon-m-star')
                ->color('info'),
        ];
    }
}
