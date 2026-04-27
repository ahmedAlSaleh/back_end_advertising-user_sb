<?php

namespace App\Filament\Admin\Resources\PromotionPackageResource\Pages;

use App\Filament\Admin\Resources\PromotionPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromotionPackages extends ListRecords
{
    protected static string $resource = PromotionPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
