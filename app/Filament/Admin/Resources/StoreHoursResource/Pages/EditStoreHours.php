<?php

namespace App\Filament\Admin\Resources\StoreHoursResource\Pages;

use App\Filament\Admin\Resources\StoreHoursResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStoreHours extends EditRecord
{
    protected static string $resource = StoreHoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
