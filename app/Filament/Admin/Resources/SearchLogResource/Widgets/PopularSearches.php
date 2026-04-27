<?php

namespace App\Filament\Admin\Resources\SearchLogResource\Widgets;

use App\Models\SearchLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class PopularSearches extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Most Popular Searches';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SearchLog::query()
                    ->select('keyword', DB::raw('count(*) as search_count'), DB::raw('AVG(results_count) as avg_results'))
                    ->whereNotNull('keyword')
                    ->where('keyword', '!=', '')
                    ->groupBy('keyword')
                    ->orderByDesc('search_count')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('keyword')
                    ->label('Search Term')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('search_count')
                    ->label('Times Searched')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('avg_results')
                    ->label('Avg Results')
                    ->formatStateUsing(fn ($state) => number_format($state, 1))
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
