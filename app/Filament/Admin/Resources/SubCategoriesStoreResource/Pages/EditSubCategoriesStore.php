<?php

namespace App\Filament\Admin\Resources\SubCategoriesStoreResource\Pages;

use App\Filament\Admin\Resources\SubCategoriesStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubCategoriesStore extends EditRecord
{
    protected static string $resource = SubCategoriesStoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
