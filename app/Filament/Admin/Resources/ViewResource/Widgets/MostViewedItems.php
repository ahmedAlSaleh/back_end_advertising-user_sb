<?php

namespace App\Filament\Admin\Resources\ViewResource\Widgets;

use App\Models\View;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class MostViewedItems extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Most Viewed Items';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                View::query()
                    ->select('viewable_type', 'viewable_id', DB::raw('count(*) as view_count'))
                    ->groupBy('viewable_type', 'viewable_id')
                    ->orderByDesc('view_count')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('viewable_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'advertisement' => 'success',
                        'store' => 'info',
                        'post' => 'warning',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('viewable_id')
                    ->label('Item ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('view_count')
                    ->label('Total Views')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->paginated(false);
    }
}
