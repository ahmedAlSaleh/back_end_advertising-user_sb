<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RechargeCodeResource\Pages;
use App\Filament\Resources\RechargeCodeResource\RelationManagers;
use App\Models\RechargeCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RechargeCodeResource extends Resource
{
    protected static ?string $model = RechargeCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Qr_number')
                    ->required()
                    ->columnSpanFull()
                    ->numeric()
                    ->label(__('Qr Number')),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->columnSpanFull()
                    ->integer()
                    ->label(__('Price')),
                Forms\Components\TextInput::make('point_number')
                    ->required()
                    ->columnSpanFull()
                    ->integer()
                    ->label(__('PointNumber')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price')) // Translated
                    ->sortable(),
                Tables\Columns\TextColumn::make('point_number')
                    ->label(__('PointNumber')) // Translated
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code')) // Translated
                    ->sortable(),
                BooleanColumn::make('is_used')
                    ->label(__('Is Used')) // Translated
                    ->boolean(),
            ])->defaultSort('id' , 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListRechargeCodes::route('/'),
            'create' => Pages\CreateRechargeCode::route('/create'),
            'view' => Pages\ViewRechargeCode::route('/{record}'),
            'edit' => Pages\EditRechargeCode::route('/{record}/edit'),
        ];
    }
}
