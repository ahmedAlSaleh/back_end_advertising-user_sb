<?php

namespace App\Filament\Resources\RechargeOperationResource\Pages;

use App\Filament\Resources\RechargeOperationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRechargeOperations extends ListRecords
{
    protected static string $resource = RechargeOperationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
