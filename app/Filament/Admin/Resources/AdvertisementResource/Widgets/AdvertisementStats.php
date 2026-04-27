<?php

namespace App\Filament\Admin\Resources\AdvertisementResource\Widgets;

use App\Models\Advertisement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdvertisementStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Advertisements', Advertisement::count())
                ->description('All advertisements')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('primary'),

            Stat::make('Active Ads', Advertisement::where('status', 'active')->count())
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Scheduled Ads', Advertisement::where('status', 'scheduled')->count())
                ->description('Waiting to go live')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Expired Ads', Advertisement::where('status', 'expired')->count())
                ->description('Past expiration date')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Featured Ads', Advertisement::where('is_featured', true)
                ->where('featured_until', '>', now())
                ->count())
                ->description('Currently featured')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Draft Ads', Advertisement::where('status', 'draft')->count())
                ->description('Not yet published')
                ->descriptionIcon('heroicon-m-document')
                ->color('gray'),
        ];
    }
}
