<?php

namespace App\Filament\Admin\Resources\ReportResource\Pages;

use App\Filament\Admin\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - reports are created via API
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReportResource\Widgets\ReportStats::class,
        ];
    }
}
