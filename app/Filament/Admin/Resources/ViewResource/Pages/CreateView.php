<?php

namespace App\Filament\Admin\Resources\ViewResource\Pages;

use App\Filament\Admin\Resources\ViewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateView extends CreateRecord
{
    protected static string $resource = ViewResource::class;
}
