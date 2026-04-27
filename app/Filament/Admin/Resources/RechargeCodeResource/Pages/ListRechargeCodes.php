<?php

namespace App\Filament\Admin\Resources\RechargeCodeResource\Pages;

use App\Filament\Admin\Resources\RechargeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRechargeCodes extends ListRecords
{
    protected static string $resource = RechargeCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
