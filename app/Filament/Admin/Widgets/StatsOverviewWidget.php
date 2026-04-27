<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use App\Models\Trader;
use App\Models\Store;
use App\Models\Category;
use App\Models\Advertisement;
use App\Models\Post;
use App\Models\RechargeOperation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Users'), User::count())
                ->description(__('All registered users'))
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make(__('Total Traders'), Trader::count())
                ->description(__('Active traders'))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([3, 2, 5, 4, 7, 6, 8, 9]),

            Stat::make(__('Total Stores'), Store::count())
                ->description(__('Registered stores'))
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning')
                ->chart([5, 6, 4, 8, 7, 6, 9, 8]),

            Stat::make(__('Total Categories'), Category::count())
                ->description(__('Product categories'))
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary'),

            Stat::make(__('Total Advertisements'), Advertisement::count())
                ->description(__('Active advertisements'))
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('danger')
                ->chart([2, 4, 3, 6, 5, 7, 6, 8]),

            Stat::make(__('Total Posts'), Post::count())
                ->description(__('Published posts'))
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}
