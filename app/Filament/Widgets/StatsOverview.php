<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Trader;
use App\Models\Advertisement;
use App\Models\Store;
use App\Models\Report;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 12, 15, 20, 25, 30, 35]),

            Stat::make('Total Traders', Trader::count())
                ->description('Registered merchants')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('primary')
                ->chart([5, 10, 15, 20, 22, 25, 28]),

            Stat::make('Total Stores', Store::count())
                ->description('Active stores')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info')
                ->chart([3, 8, 12, 18, 20, 24, 26]),

            Stat::make('Total Advertisements', Advertisement::count())
                ->description('All advertisements')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning')
                ->chart([10, 20, 30, 40, 50, 60, 70]),

            Stat::make('Active Ads', Advertisement::where('status', 'active')->count())
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Posts', Post::count())
                ->description('Community posts')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('gray'),

            Stat::make('Pending Reports', Report::where('status', 'pending')->count())
                ->description('Awaiting review')
                ->descriptionIcon('heroicon-m-flag')
                ->color('danger'),

            Stat::make('Today Registrations', User::whereDate('created_at', today())->count() + Trader::whereDate('created_at', today())->count())
                ->description('New users + traders today')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),
        ];
    }
}
