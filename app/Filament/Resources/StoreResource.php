<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.business_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.stores');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.stores');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.stores');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('store_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('store_owner_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('store_number')
                    ->required()
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('stores')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('store_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('store_owner_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('store_number')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
