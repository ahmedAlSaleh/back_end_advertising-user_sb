<?php

namespace App\Filament\Admin\Resources\LikeResource\Pages;

use App\Filament\Admin\Resources\LikeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLike extends CreateRecord
{
    protected static string $resource = LikeResource::class;
}
