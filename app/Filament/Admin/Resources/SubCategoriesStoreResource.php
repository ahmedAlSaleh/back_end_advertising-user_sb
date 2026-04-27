<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubCategoriesStoreResource\Pages;
use App\Filament\Admin\Resources\SubCategoriesStoreResource\RelationManagers;
use App\Models\SubCategoriesStore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubCategoriesStoreResource extends Resource
{
    protected static ?string $model = SubCategoriesStore::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'ربط التصنيفات بالمتجر';

    protected static ?string $navigationGroup = 'التصنيفات';

    protected static ?string $modelLabel = 'ربط تصنيف';

    protected static ?string $pluralModelLabel = 'ربط التصنيفات بالمتاجر';

    protected static ?int $navigationSort = 4;

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
            'index' => Pages\ListSubCategoriesStores::route('/'),
            'create' => Pages\CreateSubCategoriesStore::route('/create'),
            'edit' => Pages\EditSubCategoriesStore::route('/{record}/edit'),
        ];
    }
}
