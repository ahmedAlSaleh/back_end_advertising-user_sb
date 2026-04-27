<?php

namespace App\Filament\Resources\RechargeCodeResource\Pages;

use App\Filament\Resources\RechargeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRechargeCode extends EditRecord
{
    protected static string $resource = RechargeCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
