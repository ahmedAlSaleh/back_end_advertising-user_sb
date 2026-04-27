<?php

namespace App\Filament\Admin\Resources\RechargeCodeResource\Pages;

use App\Filament\Admin\Resources\RechargeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRechargeCode extends EditRecord
{
    protected static string $resource = RechargeCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
