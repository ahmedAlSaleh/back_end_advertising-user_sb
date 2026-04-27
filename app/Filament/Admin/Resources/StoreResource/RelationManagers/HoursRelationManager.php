<?php

namespace App\Filament\Admin\Resources\StoreResource\RelationManagers;

use App\Models\StoreHours;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HoursRelationManager extends RelationManager
{
    protected static string $relationship = 'hours';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('day')
                    ->options(StoreHours::getDayNames())
                    ->required(),

                Forms\Components\Toggle::make('is_closed')
                    ->label('Closed')
                    ->reactive()
                    ->default(false),

                Forms\Components\TimePicker::make('opens_at')
                    ->label('Opens At')
                    ->seconds(false)
                    ->hidden(fn ($get) => $get('is_closed'))
                    ->required(fn ($get) => !$get('is_closed')),

                Forms\Components\TimePicker::make('closes_at')
                    ->label('Closes At')
                    ->seconds(false)
                    ->hidden(fn ($get) => $get('is_closed'))
                    ->required(fn ($get) => !$get('is_closed')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('day')
            ->columns([
                Tables\Columns\TextColumn::make('day')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Sunday' => 'warning',
                        'Monday' => 'primary',
                        'Tuesday' => 'success',
                        'Wednesday' => 'info',
                        'Thursday' => 'danger',
                        'Friday' => 'gray',
                        'Saturday' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_closed')
                    ->label('Closed')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),

                Tables\Columns\TextColumn::make('opens_at')
                    ->label('Opens')
                    ->time('g:i A')
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('closes_at')
                    ->label('Closes')
                    ->time('g:i A')
                    ->placeholder('N/A'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_closed')
                    ->label('Closed'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('day', 'asc');
    }
}
