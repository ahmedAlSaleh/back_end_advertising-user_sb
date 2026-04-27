<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvertisementResource\Pages;
use App\Filament\Resources\AdvertisementResource\RelationManagers;
use App\Models\Advertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.content_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.advertisements');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.advertisements');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.advertisements');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('trader_id')
                    ->relationship('trader', 'owner_contact_number')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Trader'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0),
                Forms\Components\TextInput::make('type')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('trader.store.store_name')
                    ->label('Store')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdvertisements::route('/'),
            'create' => Pages\CreateAdvertisement::route('/create'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
