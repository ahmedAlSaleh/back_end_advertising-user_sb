<?php

namespace App\Filament\Admin\Resources\StoreHoursResource\Pages;

use App\Filament\Admin\Resources\StoreHoursResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoreHours extends ListRecords
{
    protected static string $resource = StoreHoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
