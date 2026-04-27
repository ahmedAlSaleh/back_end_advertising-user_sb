<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TraderResource\Pages;
use App\Filament\Resources\TraderResource\RelationManagers;
use App\Models\Trader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TraderResource extends Resource
{
    protected static ?string $model = Trader::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.user_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.traders');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.traders');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.traders');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('store_id')
                    ->relationship('store', 'store_name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('store_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('store_owner_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('store_number')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->image(),
                    ]),
                Forms\Components\TextInput::make('owner_contact_number')
                    ->required()
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->maxLength(255)
                    ->visibleOn('create'),
                Forms\Components\TextInput::make('whatsapp_number')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telegram_number')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('social_media_link')
                    ->url()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.store_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner_contact_number')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('whatsapp_number')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('telegram_number')
                    ->searchable(),
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
            'index' => Pages\ListTraders::route('/'),
            'create' => Pages\CreateTrader::route('/create'),
            'edit' => Pages\EditTrader::route('/{record}/edit'),
        ];
    }
}
