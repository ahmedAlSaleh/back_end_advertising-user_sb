<?php

namespace App\Filament\Admin\Resources\SubCategoriesStoreResource\Pages;

use App\Filament\Admin\Resources\SubCategoriesStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubCategoriesStores extends ListRecords
{
    protected static string $resource = SubCategoriesStoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
