<?php

namespace App\Filament\Admin\Resources\FavoriteResource\Pages;

use App\Filament\Admin\Resources\FavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFavorite extends CreateRecord
{
    protected static string $resource = FavoriteResource::class;
}
