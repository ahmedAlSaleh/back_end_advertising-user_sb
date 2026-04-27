<?php

namespace App\Filament\Resources\RechargeCodeResource\Pages;

use App\Filament\Resources\RechargeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRechargeCode extends ViewRecord
{
    protected static string $resource = RechargeCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
