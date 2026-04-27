<?php

namespace App\Filament\Admin\Resources\BlockResource\Pages;

use App\Filament\Admin\Resources\BlockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlock extends EditRecord
{
    protected static string $resource = BlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
