<?php

namespace App\Filament\Admin\Resources\ViewResource\Pages;

use App\Filament\Admin\Resources\ViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListViews extends ListRecords
{
    protected static string $resource = ViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - views are auto-recorded
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ViewResource\Widgets\ViewStatsOverview::class,
            ViewResource\Widgets\MostViewedItems::class,
        ];
    }
}
