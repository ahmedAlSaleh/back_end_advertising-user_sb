<?php

namespace App\Filament\Admin\Resources\SearchLogResource\Pages;

use App\Filament\Admin\Resources\SearchLogResource;
use App\Models\SearchLog;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSearchLogs extends ListRecords
{
    protected static string $resource = SearchLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Removed create action as this is view-only logs
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Searches'),
            'today' => Tab::make('Today')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('created_at', today())),
            'this_week' => Tab::make('This Week')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            'this_month' => Tab::make('This Month')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('created_at', now()->month)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SearchLogResource\Widgets\SearchStatsOverview::class,
            SearchLogResource\Widgets\PopularSearches::class,
        ];
    }
}
