<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RechargeOperationResource\Pages;
use App\Filament\Resources\RechargeOperationResource\RelationManagers;
use App\Models\RechargeOperation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RechargeOperationResource extends Resource
{
    protected static ?string $model = RechargeOperation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.financial_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('navigation.recharge_operations');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.recharge_operations');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.recharge_operations');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListRechargeOperations::route('/'),
            'create' => Pages\CreateRechargeOperation::route('/create'),
            'edit' => Pages\EditRechargeOperation::route('/{record}/edit'),
        ];
    }
}
