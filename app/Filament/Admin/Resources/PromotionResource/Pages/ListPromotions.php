<?php

namespace App\Filament\Admin\Resources\PromotionResource\Pages;

use App\Filament\Admin\Resources\PromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromotions extends ListRecords
{
    protected static string $resource = PromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - promotions are created via API
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PromotionResource\Widgets\PromotionStats::class,
        ];
    }
}
